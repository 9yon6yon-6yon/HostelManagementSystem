<?php

$pageTitle = 'Forgot Password';
$content = '
<div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">
    <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
        
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Hostel Management <span class="tx-info tx-normal">Forgot Password</span></div> 
            <form id="reset">
                <div id="alerts"></div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Enter email address"  >
                </div><!-- form-group -->
                <button type="submit" class="btn btn-info btn-block" >Send Reset Link</button>
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
  
    function forgotpassword() {
        var formData = {
            action:'forgotpassword',
            email: $('input[name=\"email\"]').val(),
        };
  
        if ( !formData.email ) {
            showAlert('warning', 'Please fill in all required fields.');
            return;
        }
  
        // Perform AJAX request to your PHP script for user creation
        $.ajax({
            type: 'POST',
            url: 'process.php',//needs to inplement the link to process the request
            data: formData,
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.success);
                    $('#reset')[0].reset();
                } else if (response.error) {
                    showAlert('error', response.error);
                } else if (response.redirect) {
                    window.location.href = response.redirect;
                }
            },
            error: function(error) {
                console.error(error);
                showAlert('error', 'An error occurred while processing your request.');
            }
          
        });
        console.log(formData);
    }
  
    // Add event listener for form submission
    $('#reset').on('submit', function(e) {
        e.preventDefault();
        forgotpassword();
    });
});";

include 'base.php';
