<?= script_tag(APP_ASSETS_VENDOR . "/js/vendors.min.js") ?>

<?= script_tag(APP_ASSETS_JS . "/core/app-menu.js") ?>

<?= script_tag(APP_ASSETS_VENDOR . "/js/forms/validation/jquery.validate.min.js") ?>

<?= script_tag(APP_ASSETS_JS . "/core/app.js") ?>

<script>
    $('nav .user-name').html(user_nama_lengkap);
    $('nav .user-status').html(user_jabatan);
</script>