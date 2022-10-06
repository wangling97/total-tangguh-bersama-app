/*=========================================================================================
  File Name: auth-login.js
  Description: Auth login js file.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: PIXINVENT
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
  'use strict';

  var pageLoginForm = $('.auth-login-form');

  // jQuery Validation
  // --------------------------------------------------------------------
  if (pageLoginForm.length) {
    pageLoginForm.validate({
      rules: {
        'login-username': {
          required: true
        },
        'login-password': {
          required: true
        }
      },
      submitHandler: function () {
        var payload = pageLoginForm.serialize();

        $.ajax({
          type: 'POST',
          url: "http://localhost:3000/api/auth/login",
          headers: { 'X-Requested-With': 'XMLHttpRequest' },
          data: payload,
          dataType: 'json',
          beforeSend: function () {
            loadingOverlay();
          },
          success: function (response) {
            console.info(response);
          },
          error: function (request) {
            alertMessage('warning', 'Peringatan', request.responseJSON.messages.error);
          },
          complete: function () {
            $.unblockUI();
          }
        });
      }
    });
  }
});
