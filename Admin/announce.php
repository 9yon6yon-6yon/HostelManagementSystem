<?php
require('../Admin/DatabaseHandler.php');
$pageTitle = "Make Announcement";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'announce.php', 'label' => 'Make Announcement'],

];

$databaseHandler = new DatabaseHandler();

$content = '
<div class="card pd-20 pd-sm-40">
  <h6 class="card-body-title">Announcement Form</h6>
  <p class="mg-b-20 mg-sm-b-30">Make a new announcement</p>

  <div class="form-layout">
    <form id="announcementForm"> 
      <div class="row mg-b-25">
        <div class="form-group col-lg-8">
            <label class="form-control-label">Title: <span class="tx-danger">*</span></label>
            <input class="form-control" type="text" name="title" value="" placeholder="Enter title">
        </div>

          <div class="form-group mg-b-10-force col-lg-4">
            <label class="form-control-label mg-r-10">Visibility<span class="tx-danger">*</span></label>
            <select class="form-control select2 mg-r-10" name="visibility" data-placeholder="Choose visibility">
              <option label="Choose visibility"></option>
              <option value="public">Everyone</option>
              <option value="admin">Admins</option>
              <option value="student">Students</option>
              <option value="provost">Provosts</option>
              <option value="hallsuper">Hall Supers</option>
              <option value="accounts">Accounts</option>
            </select>
          </div>

        <div class="col-lg-12">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Description: <span class="tx-danger">*</span></label>
            <textarea class="form-control" name="description" placeholder="Enter description"></textarea>
          </div>
        </div><!-- col-8 -->
      </div><!-- row -->

      <div class="form-layout-footer">
        <button type="submit" name="submit" class="btn btn-info mg-r-5">Announce Notice</button>
        <button id="cancelButton" type="button" name="cancel" class="btn btn-secondary">Cancel</button>
      </div><!-- form-layout-footer -->

    </form>
  </div><!-- form-layout -->
</div><!-- card -->
';

$script = "
$(function() {
    'use strict';
  
    // Initialize Select2
    $('.select2').select2({
        minimumResultsForSearch: Infinity
    });
  
    function MakeNotice() {
        var formData = {
            action:'make-notice',
            title: $('input[name=\"title\"]').val(),
            visibility: $('select[name=\"visibility\"]').val(),
            description: $('textarea[name=\"description\"]').val(),
        };
  
        if ( !formData.title || !formData.visibility || !formData.description) {
            showAlert('warning', 'Please fill in all required fields.');
            return;
        }
  
        $.ajax({
            type: 'POST',
            url: 'process.php',//needs to inplement the link to process the request
            data: formData,
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.success);
                    $('#announcementForm')[0].reset();
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
    function resetForm() {
        $('#announcementForm')[0].reset();
    }

    $('#announcementForm').on('submit', function(e) {
        e.preventDefault();
        MakeNotice();
    });
    $('#cancelButton').on('click', function(e) {
        e.preventDefault();
        resetForm();
    });

});
";


include '../templates/base.php';
