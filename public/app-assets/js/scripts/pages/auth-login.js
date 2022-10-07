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
            Cookies.set('token', response.token, { secure: true, sameSite: 'strict' });
            alertMessage('success', 'Pesan', response.message, location.origin + '/pages/dashboard');
          },
          error: function (request) {
            if (request.responseJSON.error == 400) {
              if (request.responseJSON.messages.username) {
                alertMessage('warning', 'Peringatan', request.responseJSON.messages.username);
                return;
              }

              if (request.responseJSON.messages.password) {
                alertMessage('warning', 'Peringatan', request.responseJSON.messages.password);
                return;
              }
            }

            if (request.responseJSON.error == 401) {
              alertMessage('warning', 'Peringatan', request.responseJSON.messages.error);
            }
          },
          complete: function () {
            $.unblockUI();
          }
        });
      }
    });
  }
});
