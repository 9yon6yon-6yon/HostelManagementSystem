
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
                <label class='form-control-label mg-r-10'>Type of application<span
                        class='tx-danger'>*</span></label>
                <select class='form-control select2 mg-r-10' name='type' data-placeholder='Choose an option'
                    id='applicationType'>
                    <option label='Choose a type'></option>
                    <option value='room_allocation'>Book Seat</option>
                    <option value='renew_room_allocation'>Renew Seat</option>
                    <option value='cancel'>Cancel Seat</option>
                    <option value='complaint'>Complaint</option>
                    <option value='leave'>Leave</option>

                </select>
            </div>
            <div class='form-group mg-b-10-force col-lg-4' id='roomSelectionDiv' style='display: none;'>
                <label class='form-control-label mg-r-10'>Select Room<span
                        class='tx-danger'>*</span></label>
                <select class='form-control select2 mg-r-10' name='room' data-placeholder='Choose an option'
                    id='room-no'>
                    <option label='Choose a type'></option>
                </select>
            </div>
            <div class='form-group mg-b-10-force col-lg-4' id='seatSelectionDiv' style='display: none;'>
                <label class='form-control-label mg-r-10'>Select Seat<span
                        class='tx-danger'>*</span></label>
                <select class='form-control select2 mg-r-10' name='seat' data-placeholder='Choose an option'
                    id='seat-no'>
                    <option label='Choose a type'></option>
                </select>
            </div>
            <div class='col-lg-12'>
                <div class='form-group mg-b-10-force'>
                    <label class='form-control-label'>Description: <span class='tx-danger'>*</span></label>
                    <textarea class='form-control' name='description'
                        placeholder='Enter description'></textarea>
                </div>
            </div><!-- col-8 -->
        </div><!-- row -->
        <div class='form-layout-footer'>
            <button type='submit' name='submit' class='btn btn-primary mg-r-5'>Apply</button>
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
  });
  $('#cancelButton').on('click', function (e) {
      e.preventDefault();
      resetForm();
  });
  $('#applicationType').on('change', function () {
      var selectedValue = $(this).val();


      if (selectedValue === 'room_allocation') {
          $('#roomSelectionDiv, #seatSelectionDiv').show();
          $.ajax({
              url: 'process.php',
              type: 'GET',
              data: {
                  action: 'load-room',
              },
              dataType: 'json',
              success: function (roomData) {
                  var roomSelect = $('#room-no');

                  $.each(roomData, function (index, room) {
                      roomSelect.append('<option value=' + room.room_no + '>' + room.room_no + '</option>');
                  });
              },
              error: function () {
                  console.error('Ajax request for rooms failed');
              }
          });

      } else {
          $('#roomSelectionDiv, #seatSelectionDiv').hide();
      }
  });
  $('#room-no').on('change', function () {
      var selectedRoomId = $(this).val();
      $.ajax({
          url: 'process.php',
          type: 'GET',
          dataType: 'json',
          data: {
              action: 'load-seat',
              room_id: selectedRoomId
          },
          success: function (seatData) {
              var seatSelect = $('#seat-no');
              seatSelect.empty();
              $.each(seatData, function (index, seat) {
                  seatSelect.append('<option value=' + seat.seat_id + '>' + seat.seat_no + '</option>');
              });
          },
          error: function () {
              console.error('Ajax request for seats failed');
          }
      });
  });
});
";


include '../templates/base.php';
