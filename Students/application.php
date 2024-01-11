
<?php

$pageTitle = "Apply";
$pages = [
  ['url' => 'dashboard.php', 'label' => 'Dashboard'],
  ['url' => 'application.php', 'label' => 'Application'],

];

$content = "

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
                        

                    </select>
                </div>
                <div class='form-group mg-b-10-force col-lg-4' id='roomSelectionDiv' style='display: none;'>
                    <label class='form-control-label mg-r-10'>Select Room<span class='tx-danger'>*</span></label>
                    <select class='form-control select2 mg-r-10' name='room' data-placeholder='Choose an option'
                        id='room-no'>
                        <option label='Choose a type'></option>
                    </select>
                </div>
                <div class='form-group mg-b-10-force col-lg-4' id='seatSelectionDiv' style='display: none;'>
                    <label class='form-control-label mg-r-10'>Select Seat<span class='tx-danger'>*</span></label>
                    <select class='form-control select2 mg-r-10' name='seat_no' data-placeholder='Choose an option'
                        id='seat-no'>
                        <option label='Choose a type'></option>
                    </select>
                </div>
                <div class='form-group mg-b-10-force col-lg-4' id='selectStartDate' style='display: none;'>
                    <label class='form-control-label mg-r-10'>Select Start Date<span
                            class='tx-danger'>*</span></label>
                    
                    <input  type='date' class='form-control' name='start' placeholder='MM/DD/YYYY'>

                </div>
                <div class='form-group mg-b-10-force col-lg-4' id='selectEndDate' style='display: none;'>
                    <label class='form-control-label mg-r-10'>Select End Date<span
                            class='tx-danger'>*</span></label>
                   
                    <input  type='date' class='form-control' name='end' placeholder='MM/DD/YYYY'>

                </div>
            </div><!-- row -->
            <div class='form-layout-footer'>
                <button type='submit' name='submit' class='btn btn-primary mg-r-5' id='book-seat'>Apply</button>
                <button id='cancelButton' type='button' name='discard' class='btn btn-secondary'>Discard
                    Changes</button>
            </div><!-- form-layout-footer -->
        </form>
    </div><!-- form-layout -->
</div>
<div class='card pd-20 pd-sm-40 mg-t-50' id='viewPreAppliations' style='display: none;'>
    <h6 class='card-body-title'>Your Listings</h6>
    <div class='table-wrapper' id='viewpendingApplications'>
            <table id='datatable1' class='table display responsive nowrap'>
              <thead>
                <tr>
                  <th class='wd-15p'>Room no</th>
                  <th class='wd-15p'>Seat no</th>
                  <th class='wd-15p'>Building</th>
                  <th class='wd-20p'>Status</th>
                  <th class='wd-15p'>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
    </div>
    <form id='renewapplicationform'>
    <div class='row mg-b-25'>
        <input  type='text' class='form-group form-control' name='sa_id' id='seatAllocationId' hidden>
        <div class='form-group mg-b-10-force col-lg-4' id='roomReadonly' style='display: none;'>
        <label class='form-control-label mg-r-10'>Select Room<span class='tx-danger'>*</span></label>
        <select class='form-control select2 mg-r-10' name='room' data-placeholder='Choose an option'
            id='room-no-read' readonly>
            <option label='Choose a type'></option>
        </select>
    </div>
    <div class='form-group mg-b-10-force col-lg-4' id='seatReadonly' style='display: none;'>
        <label class='form-control-label mg-r-10'>Select Seat<span class='tx-danger'>*</span></label>
        <select class='form-control select2 mg-r-10' name='seat_no' data-placeholder='Choose an option'
            id='seat-no-read' readonly>
            <option label='Choose a type'></option>
        </select>
    </div>
    <div class='form-group mg-b-10-force col-lg-4' id='StartDate' style='display: none;'>
        <label class='form-control-label mg-r-10'>Select Start Date<span
                class='tx-danger'>*</span></label>
        
        <input  type='date' class='form-control' name='start' placeholder='MM/DD/YYYY'>

    </div>
    <div class='form-group mg-b-10-force col-lg-4' id='EndDate' style='display: none;'>
        <label class='form-control-label mg-r-10'>Select End Date<span
                class='tx-danger'>*</span></label>
       
        <input  type='date' class='form-control' name='end' placeholder='MM/DD/YYYY'>

    </div>
        <div class='col-lg-12'>
            <div class='form-group mg-b-10-force'>
                <label class='form-control-label tx-danger' id='nodatamessage' style='display: none;'>No application available</label>
            </div>
        </div><!-- col-8 -->
    </div><!-- row -->
    <div class='form-layout-footer'>
        <button type='submit' name='submit' class='btn btn-primary mg-r-5' id='re-apply' style='display: none;'>Renew</button>
        <button type='button' name='cancel' class='btn btn-secondary' id='cancelapplication' >Cancel</button>
    </div><!-- form-layout-footer -->
</form>
</div>
";

$script = "
$(function () {
    'use strict';

    function resetForm() {
        $('#applicationform')[0].reset();
        $('#viewPreAppliations').hide();
    }

    $('#applicationform').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        formData += '&action=seat-book';

        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    showAlert('success', response.success);
                    $('#applicationform')[0].reset();
                } else {
                    showAlert('error', response.error);
                }
            },
            error: function () {
                console.error('Ajax request for seat book failed');
            }
        });
    });
    $('#cancelButton').on('click', function (e) {
        e.preventDefault();
        resetForm();
    });
    $('#applicationType').on('change', function () {
        var selectedValue = $(this).val();


        if (selectedValue === 'room_allocation') {
            $('#roomSelectionDiv, #seatSelectionDiv, #selectStartDate, #selectEndDate').show();
            $('#viewpendingApplications, #roomReadonly, #seatReadonly, #StartDate, #EndDate').hide();
            $('#viewPreAppliations').hide();
            $('#book-seat').show();
            $.ajax({
                url: 'process.php',
                type: 'GET',
                data: {
                    action: 'load-room',
                },
                dataType: 'json',
                success: function (roomData) {
                    var roomSelect = $('#room-no');
                    roomSelect.empty();
                    $.each(roomData, function (index, room) {
                        roomSelect.append('<option value=' + room.room_id + '>' + room.room_no + ' ' + room.building_name + '</option>');
                    });
                },
                error: function () {
                    console.error('Ajax request for rooms failed');
                }
            });

        } else if (selectedValue === 'renew_room_allocation') {
            $('#viewpendingApplications, #roomSelectionDiv, #seatSelectionDiv, #selectStartDate, #selectEndDate').hide();
            $('#viewPreAppliations').show();
            $('#book-seat').hide();
            $('#re-apply').show();
            $('#cancelapplication').show();
            $.ajax({
                url: 'process.php',
                type: 'GET',
                data: {
                    action: 'load-room-allocation',
                },
                dataType: 'json',
                success: function (seatApplications) {
                    if (seatApplications.length === 0) {
                        $('#nodatamessage').show();
                        $('#re-apply').hide();
                        $('#cancelapplication').hide();
                        return;
                    } else {
                        $('#nodatamessage, #viewpendingApplications').hide();
                        $('#re-apply').show();
                        $('#cancelapplication').show();
                        $('#roomReadonly, #seatReadonly, #StartDate, #EndDate').show();
                        var sa_id = $('#seatAllocationId');

                        var roomSelect = $('#room-no-read');
                        roomSelect.empty();

                        var seatSelect = $('#seat-no-read');
                        seatSelect.empty();

                        var application = seatApplications[0];
                        sa_id.val(application.seat_allocation_id);
                        // Assuming room_no and seat_no are properties of the application object
                        roomSelect.append('<option value=' + application.room_no + '>' + 'Room :' + ' ' + application.room_no + ' ' + application.building_name + '</option>');
                        seatSelect.append('<option value=' + application.seat_no + '>' + application.seat_no + '</option>');
                    }
                },
                error: function () {
                    console.error('Ajax request for renew room failed');
                }
            });

        }
        else if (selectedValue === 'cancel') {
            $('#roomSelectionDiv, #seatSelectionDiv, #selectStartDate, #selectEndDate').hide();
            $('#roomReadonly, #seatReadonly, #StartDate, #EndDate').hide();
            $('#viewPreAppliations, #viewpendingApplications').show();
            $('#re-apply').hide();
            $('#book-seat').hide();
            $('#cancelapplication').hide();
            $.ajax({
                url: 'process.php',
                type: 'GET',
                data: {
                    action: 'load-cancel-allocation',
                },
                dataType: 'json',
                success: function (seatApplications) {
                    if (seatApplications.length === 0) {
                        $('#nodatamessage').show();
                        $('#re-apply, #viewpendingApplications').hide();
                        $('#cancelapplication').hide();
                        return;
                    } else {
                        $('#datatable1 tbody').empty();

                        // Iterate through the JSON array and append rows to the table
                        $.each(seatApplications, function (index, application) {
                            var row = '<tr>' +
                                '<td>' + application.room_no + '</td>' +
                                '<td>' + application.seat_no + '</td>' +
                                '<td>' + application.building_name + '</td>' +
                                '<td>' + application.status + '</td>' +
                                '<td>' +
                                '<button class=' + 'btn btn-secondary' + ' id=' + 'remove-button' + ' data-seat-allocation-id=' + application.seat_allocation_id + '>Remove</button>' +
                                '</td>' +
                                '</tr>';
                            $('#datatable1 tbody').append(row);
                        });

                        // Show the table and other necessary elements
                        $('#viewpendingApplications').show();
                        $('#nodatamessage').hide();
                        $('#re-apply, #cancelapplication').hide();
                    }
                },
                error: function () {
                    console.error('Ajax request for cancel room failed');
                }
            });

        }
        else {
            $('#roomSelectionDiv, #seatSelectionDiv, #selectStartDate, #selectEndDate').hide();
            $('#viewPreAppliations').hide();
            $('#book-seat').show();
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
                    seatSelect.append('<option value=' + seat.seat_id + '>' + 'Seat no : ' + seat.seat_id + ' -->' + seat.status + '</option>');
                });
            },
            error: function () {
                console.error('Ajax request for seats failed');
            }
        });
    });
    $('#renewapplicationform').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        formData += '&action=renew-room';

        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    showAlert('success', response.success);
                    $('#renewapplicationform')[0].reset();
                } else {
                    showAlert('error', response.error);
                }
            },
            error: function () {
                console.error('Ajax request for seat book failed');
            }
        });
    });
    $('#cancelapplication').on('click', function (e) {
        e.preventDefault();

        // Create a FormData object and append the action and sa_id
        var formData = new FormData();
        formData.append('action', 'room-cancel');
        formData.append('sa_id', $('#seatAllocationId').val());

        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    showAlert('success', response.success);
                } else {
                    showAlert('error', response.error);
                }
            },
            error: function () {
                console.error('Ajax request for seat book failed');
            }
        });
    });
    $('#datatable2').DataTable({
        bLengthChange: false,
        searching: false,
        responsive: true
    });
    $('#viewpendingApplications').on('click', '#remove-button', function (e) {
        e.preventDefault();

        var seatAllocationId = $(this).data('seat-allocation-id');

        // Perform your AJAX request or any other action based on the extracted seat_allocation_id
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: {
                action: 'room-cancel',
                sa_id: seatAllocationId
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    showAlert('success', response.success);

                } else {
                    showAlert('error', response.error);
                }
            },
            error: function () {
                console.error('Ajax request for seat removal failed');
            }
        });
    });
});
";


include '../templates/base.php';
