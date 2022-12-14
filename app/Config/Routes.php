<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Pages\Dashboard::index');

$routes->get('login', 'Pages\Auth::login');

$routes->group('pages', function ($routes) {
    $routes->get('dashboard', 'Pages\Dashboard::index');
});


// API
$routes->group('api', ['filter' => 'authFilter'], function ($routes) {
    $routes->group('provinsi',  function ($routes) {
        $routes->get('/', 'Api\ApiProvinsi::index');
    });

    $routes->group('kabupaten', function ($routes) {
        $routes->get('/', 'Api\ApiKabupaten::index');
    });

    $routes->group('kecamatan', function ($routes) {
        $routes->get('/', 'Api\ApiKecamatan::index');
    });

    $routes->group('kelurahan', function ($routes) {
        $routes->get('/', 'Api\ApiKelurahan::index');
    });

    $routes->group('pengguna', function ($routes) {
        $routes->get('/', 'Api\ApiPengguna::index');
        $routes->post('/', 'Api\ApiPengguna::tambah');
        $routes->put('/', 'Api\ApiPengguna::ubah');
        $routes->delete('/', 'Api\ApiPengguna::hapus');
    });
});

$routes->group('api', function ($routes) {
    $routes->group('auth', function ($routes) {
        $routes->post('login', 'Api\ApiAuth::login');
        $routes->post('token', 'Api\ApiAuth::token');
    });
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
