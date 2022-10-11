<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
<title><?= $title; ?> - <?= APP_NAME; ?></title>
<?= link_tag(APP_ASSETS_IMG . '/ico/favicon.ico', 'apple-touch-icon') ?>

<?= link_tag(APP_ASSETS_IMG . '/ico/favicon.ico', 'shortcut icon') ?>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

<!-- BEGIN: Vendor CSS-->
<?= link_tag(APP_ASSETS_VENDOR . '/css/vendors.min.css'); ?>
<?= link_tag(APP_ASSETS_VENDOR . '/css/animate/animate.min.css'); ?>
<?= link_tag(APP_ASSETS_VENDOR . '/css/extensions/sweetalert2.min.css'); ?>

<?php if ($title == 'Data Admin') : ?>
    <?= link_tag(APP_ASSETS_VENDOR . '/css/tables/datatable/dataTables.bootstrap5.min.css'); ?>
    <?= link_tag(APP_ASSETS_VENDOR . '/css/tables/datatable/responsive.bootstrap5.min.css'); ?>
    <?= link_tag(APP_ASSETS_VENDOR . '/css/tables/datatable/buttons.bootstrap5.min.css'); ?>
<?php endif; ?>
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<?= link_tag(APP_ASSETS_CSS . '/bootstrap.css'); ?>
<?= link_tag(APP_ASSETS_CSS . '/bootstrap-extended.css'); ?>
<?= link_tag(APP_ASSETS_CSS . '/colors.css'); ?>
<?= link_tag(APP_ASSETS_CSS . '/components.css'); ?>
<?= link_tag(APP_ASSETS_CSS . '/themes/dark-layout.css'); ?>
<?= link_tag(APP_ASSETS_CSS . '/themes/bordered-layout.css'); ?>
<?= link_tag(APP_ASSETS_CSS . '/themes/semi-dark-layout.css'); ?>

<!-- END: Theme CSS-->

<!-- BEGIN: Page CSS-->
<?= link_tag(APP_ASSETS_CSS . '/core/menu/menu-types/vertical-menu.css'); ?>

<?php if ($title == 'Login' || $title == 'Data Admin') : ?>
    <?= link_tag(APP_ASSETS_CSS . '/plugins/forms/form-validation.css'); ?>
<?php endif; ?>

<?php if ($title == 'Login') : ?>
    <?= link_tag(APP_ASSETS_CSS . '/pages/authentication.css'); ?>
<?php endif; ?>
<!-- END: Page CSS-->

<!-- BEGIN: Custom CSS-->
<?= link_tag(ASSETS_CSS . '/style.css'); ?>

<!-- END: Custom CSS-->

<?= script_tag(APP_ASSETS_VENDOR . "/js/jquery/jquery.min.js") ?>
<?= script_tag(APP_ASSETS_VENDOR . "/js/js-cookie/dist/js.cookie.min.js") ?>
<?= script_tag(APP_ASSETS_VENDOR . "/js/extensions/sweetalert2.all.min.js") ?>
<?= script_tag(APP_ASSETS_VENDOR . "/js/extensions/polyfill.min.js") ?>

<script>
    const BASE_URL = location.origin;
    const PATH = location.pathname.split('/');
    const TOKEN = Cookies.get('token');
    const THEME = Cookies.get('theme');

    var user_nama_lengkap = "";
    var user_jabatan = "";

    if (PATH[1] != "login") {
        if (!TOKEN) {
            Cookies.set('flash_message', 'Silahkan login terlebih dahulu!');
            window.location.replace(BASE_URL + "/login");
        } else {
            $.ajax({
                type: 'POST',
                url: "http://localhost:3000/api/auth/token",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Authorization': TOKEN
                },
                success: function(response) {
                    if (response.message == "Refresh") {
                        Cookies.set('token', response.token);
                    } else {
                        user_nama_lengkap = response.pengguna.nama_depan;
                        user_jabatan = response.pengguna.jabatan;

                        if (response.pengguna.nama_belakang) {
                            user_nama_lengkap += " " + response.pengguna.nama_belakang;
                        }
                    }
                },
                error: function(request, status) {
                    Cookies.set('flash_message', request.responseJSON);
                    window.location.replace(BASE_URL + "/login");
                }
            });
        }
    } else {
        if (TOKEN) {
            window.location.replace(BASE_URL);
        }
    }

    var flash_message = Cookies.get('flash_message');

    if (flash_message) {
        alert(flash_message);
        Cookies.remove('flash_message');
    }

    if (THEME) {
        if (THEME == 'light') {
            $("html").addClass("light-layout");
        } else {
            $("html").addClass("dark-layout");
        }
    } else {
        Cookies.set('theme', 'light');

        $("html").addClass("light-layout");
    }

    function changeTheme() {
        if (THEME) {
            if (THEME == 'light') {
                Cookies.set('theme', 'dark');
            } else {
                Cookies.set('theme', 'light');
            }
        } else {
            Cookies.set('theme', 'light');
        }
    }
</script>