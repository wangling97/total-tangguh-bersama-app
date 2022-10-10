<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
<title>Login Page - <?= APP_NAME; ?></title>
<?= link_tag(APP_ASSETS_IMG . '/ico/favicon.ico', 'apple-touch-icon') ?>

<?= link_tag(APP_ASSETS_IMG . '/ico/favicon.ico', 'shortcut icon') ?>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

<?= link_tag(APP_ASSETS_VENDOR . '/css/vendors.min.css'); ?>

<?= link_tag(APP_ASSETS_VENDOR . '/css/animate/animate.min.css'); ?>

<?= link_tag(APP_ASSETS_VENDOR . '/css/extensions/sweetalert2.min.css'); ?>

<?= link_tag(APP_ASSETS_CSS . '/bootstrap.css'); ?>

<?= link_tag(APP_ASSETS_CSS . '/bootstrap-extended.css'); ?>

<?= link_tag(APP_ASSETS_CSS . '/colors.css'); ?>

<?= link_tag(APP_ASSETS_CSS . '/components.css'); ?>

<?= link_tag(APP_ASSETS_CSS . '/themes/dark-layout.css'); ?>

<?= link_tag(APP_ASSETS_CSS . '/themes/bordered-layout.css'); ?>

<?= link_tag(APP_ASSETS_CSS . '/themes/semi-dark-layout.css'); ?>

<?= script_tag(APP_ASSETS_VENDOR . "/js/jquery/jquery.min.js") ?>

<?= script_tag(APP_ASSETS_VENDOR . "/js/js-cookie/dist/js.cookie.min.js") ?>

<?= script_tag(APP_ASSETS_VENDOR . "/js/extensions/sweetalert2.all.min.js") ?>

<?= script_tag(APP_ASSETS_VENDOR . "/js/extensions/polyfill.min.js") ?>

<script>
    const BASE_URL = location.origin;

    const PATH = location.pathname.split('/');

    if (PATH[1] != "login") {
        var token = Cookies.get('token');

        if (!token) {
            Cookies.set('flash_message', 'Silahkan login terlebih dahulu!');
            window.location.replace(BASE_URL + "/login");
        } else {
            $.ajax({
                type: 'POST',
                url: "http://localhost:3000/api/auth/token",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Authorization': token
                },
                error: function(request, status) {
                    Cookies.set('flash_message', request.responseJSON);
                    window.location.replace(BASE_URL + "/login");
                }
            });
        }
    }

    var flash_message = Cookies.get('flash_message');

    if (flash_message) {
        alert(flash_message);
        Cookies.remove('flash_message');
    }
</script>