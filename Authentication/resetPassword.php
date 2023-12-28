<?php

$pageTitle = 'Reset Password';
$token = $_GET['token'];
$email = $_GET['email'];
$content = '
<div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">
    <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
        
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Hostel Management <span class="tx-info tx-normal">Reset Password</span></div> 
            <form id="reset">
                <div id="alerts"></div>
                <input type="hidden" name="token" value="' . $token . '">
                <input type="hidden" name="email" value="' . $email . '">
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Enter new password">
                </div><!-- form-group -->
                <div class="form-group">
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm new password">
                </div><!-- form-group -->
                <button type="submit" class="btn btn-info btn-block">Submit</button>
                <div class="mg-t-60 tx-center"><a href="../index.php" class="tx-info">Back To Home</a></div>
            </form>
    </div>
</div>';


$script = "$(function() {
    'use strict';
  
    // Initialize Select2
    $('.select2').select2({
        minimumResultsForSearch: Infinity
    });
  
    function resetPassword() {
        var formData = {
            action: 'reset-password',
            email: $('input[name=\"email\"]').val(),
            token: $('input[name=\"token\"]').val(),
            password: $('input[name=\"password\"]').val(),
            confirm_password: $('input[name=\"confirm_password\"]').val(),
        };
    
        if (!formData.email || !formData.password || !formData.confirm_password || !formData.token) {
            showAlert('warning', 'Please fill in all required fields.');
            return;
        }
    
        if (formData.password !== formData.confirm_password) {
            showAlert('warning', 'Password and confirm password do not match.');
            return;
        };

        // Perform AJAX request to your PHP script for password reset
        $.ajax({
            type: 'POST',
            url: 'process.php', // Replace with the actual path to your PHP script
            data: formData,
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.success);
                    $('#reset')[0].reset();
                    setTimeout(function () {
                        window.location.href = 'login.php';
                    }, 2000);
                  
                } else if (response.error) {
                    showAlert('error', response.error);
                }
            },
            error: function(error) {
                console.error(error);
                showAlert('error', 'An error occurred while processing your request.');
            }

        });
    }

    // Add event listener for form submission
    $('#reset').on('submit', function(e) {
        e.preventDefault();
        resetPassword();
    });
});";

include 'base.php';
