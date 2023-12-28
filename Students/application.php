
<?php

$pageTitle = "Apply";
$pages = [
  ['url' => 'dashboard.php', 'label' => 'Dashboard'],
  ['url' => 'application.php', 'label' => 'Application'],

];

$content .= "

<div class='card pd-20 pd-sm-40'>
  <h6 class='card-body-title'>Application Form</h6>
  <p class='mg-b-20 mg-sm-b-30'>Submit all necessary information</p>

  <div class='form-layout'>
    <form id='applicationform'> 
      <div class='row mg-b-25'>
        
          <div class='form-group mg-b-10-force col-lg-4'>
            <label class='form-control-label mg-r-10'>Type of application<span class='tx-danger'>*</span></label>
            <select class='form-control select2 mg-r-10' name='type' data-placeholder='Choose an option'>
              <option label='Choose a type'></option>
              <option value='leave'>Leave</option>
              <option value='room_allocation'>Room Booking</option>
              <option value='complaint'>Complaint</option>
              <option value='cancel'>Cancel Room</option>
          
            </select>
          </div>

        <div class='col-lg-12'>
          <div class='form-group mg-b-10-force'>
            <label class='form-control-label'>Description: <span class='tx-danger'>*</span></label>
            <textarea class='form-control' name='description' placeholder='Enter description'></textarea>
          </div>
        </div><!-- col-8 -->
      </div><!-- row -->

      <div class='form-layout-footer'>
        <button type='submit' name='submit' class='btn btn-info mg-r-5'>Apply</button>
        <button id='cancelButton' type='button' name='cancel' class='btn btn-secondary'>Cancel</button>
      </div><!-- form-layout-footer -->

    </form>
  </div><!-- form-layout -->
</div><!-- card -->
";

$script = "
$(function () {
  'use strict';

  function resetForm() {
      $('#applicationform')[0].reset();
  }

  $('#applicationform').on('submit', function (e) {
      e.preventDefault();
      apply();
  });
  $('#cancelButton').on('click', function (e) {
      e.preventDefault();
      resetForm();
  });
});
";


include '../templates/base.php';
