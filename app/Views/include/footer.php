<!-- BEGIN: Vendor JS-->
<?= script_tag(APP_ASSETS_VENDOR . "/js/vendors.min.js") ?>
<?= script_tag(APP_ASSETS_VENDOR . "/js/forms/validation/jquery.validate.min.js") ?>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<?= script_tag(APP_ASSETS_VENDOR . "/js/tables/datatable/jquery.dataTables.min.js") ?>
<?= script_tag(APP_ASSETS_VENDOR . "/js/tables/datatable/dataTables.bootstrap5.min.js") ?>
<?= script_tag(APP_ASSETS_VENDOR . "/js/tables/datatable/dataTables.responsive.min.js") ?>
<?= script_tag(APP_ASSETS_VENDOR . "/js/tables/datatable/responsive.bootstrap5.js") ?>
<?= script_tag(APP_ASSETS_VENDOR . "/js/tables/datatable/datatables.buttons.min.js") ?>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<?= script_tag(APP_ASSETS_JS . "/core/app-menu.js") ?>
<?= script_tag(APP_ASSETS_JS . "/core/app.js") ?>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<?= script_tag(APP_ASSETS_JS . "/scripts/pages/app-user-list.js") ?>
<!-- END: Page JS-->

<script>
    $('nav .user-name').html(user_nama_lengkap);
    $('nav .user-status').html(user_jabatan);
</script>