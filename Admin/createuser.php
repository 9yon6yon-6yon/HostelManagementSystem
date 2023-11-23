<?php

$pageTitle = "Admin Dashboard";
$pages = [
  ['url' => 'createuser.php', 'label' => 'Create'],
];

$content = '<div class="d-flex align-items-center justify-content-center ">

    <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white">
      <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Hostel Management <span class="tx-info tx-normal">admin</span></div>
     
     
      <form id="createUserForm">
        <div class="form-group">
          <input type="text" class="form-control" name="username" placeholder="Enter username"  >
        </div><!-- form-group -->
        <div class="form-group">
          <input type="email" class="form-control" name="email" placeholder="Enter email address"  >
        </div><!-- form-group -->
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Enter password / default is password"  >
        </div><!-- form-group -->
          <div class="form-group">
            <select class="form-control select2" name="role" data-placeholder="Choose role">
              <option value="admin"> Admin</option>
              <option value="student"> Student</option>
              <option value="accounts"> Accounts</option>
              <option value="provost"> Provost</option>
              <option value="hallsuper"> Hall Super</option>
            </select>
          </div>

        <button type="submit" class="btn btn-info btn-block" >Create</button>
        </form>
    </div>
  </div>';

$script = "$(function() {
  'use strict';

  // Initialize Select2
  $('.select2').select2({
      minimumResultsForSearch: Infinity
  });

  function createUser() {
      var formData = {
          action:'createUser',
          username: $('input[name=\"username\"]').val(),
          email: $('input[name=\"email\"]').val(),
          password: $('input[name=\"password\"]').val(),
          role: $('select[name=\"role\"]').val()
      };

      if (!formData.username || !formData.email || !formData.password || !formData.role) {
          showAlert('warning', 'Please fill in all required fields.');
          return;
      }

      // Perform AJAX request to your PHP script for user creation
      $.ajax({
          type: 'POST',
          url: 'process.php',
          data: formData,
          success: function(response) {
              if (response.success) {
                  showAlert('success', response.success);
                  $('#createUserForm')[0].reset();
              } else if (response.error) {
                  showAlert('error', response.error);
              }
          },
          error: function(error) {
              console.error(error);
              showAlert('error', 'An error occurred while processing your request.');
          }
      });
      console.log(formData);
  }

  function showAlert(type, message) {
      var alertClasses = {
        'success': 'alert-success',
        'danger': 'alert-danger',
        'info': 'alert-info',
        'warning': 'alert-warning',
        'primary': 'alert-primary',
        'secondary': 'alert-secondary'
      };

      var alertClass = alertClasses[type] || 'alert-info';
      var alertHtml = '<div class=\"alert ' + alertClass + ' alert-dismissible fade show\" role=\"alert\">' +
          message +
          '<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">' +
          '<span aria-hidden=\"true\">&times;</span>' +
          '</button>' +
          '</div>';

      // Append the alert to a container (e.g., a div with id=\"alerts\")
      $('#alerts').html(alertHtml);
  }

  // Add event listener for form submission
  $('#createUserForm').on('submit', function(e) {
      e.preventDefault();
      createUser();
  });
});";

include '../templates/base.php';
