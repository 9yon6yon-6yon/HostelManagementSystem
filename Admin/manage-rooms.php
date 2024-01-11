<?php

$pageTitle = "Room applications";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'manage-rooms.php', 'label' => 'Room applications'],

];

$content = "
<div class='card pd-20 pd-sm-40 mg-t-50' id='viewAppliations''>
    <h6 class='card-body-title'>Listing Applications</h6>
    <div class='table-wrapper' id='viewpendingApplications'>
            <table id='datatable1' class='table display responsive nowrap'>
              <thead>
                <tr>
                 <th class='wd-15p'>Name</th>
                  <th class='wd-15p'>Room no</th>
                  <th class='wd-15p'>Seat no</th>
                  <th class='wd-15p'>Building</th>
                  <th class='wd-15p'>Start Date</th>
                  <th class='wd-15p'>End Date</th>
                  <th class='wd-20p'>Status</th>
                  <th class='wd-15p'>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
    </div>
</div>
";
$script = "
$(function () {
    'use strict';

    function loadTableData() {
        $.ajax({
            url: 'process.php',
            type: 'GET',
            data: {
                action: 'load-allocation-table',
            },
            dataType: 'json',
            success: function (seatApplications) {
                if (seatApplications.length === 0) {
                    $('#datatable1 tbody').empty();
                    $('#datatable1 tbody').append('<tr><td>No Pending Request</td></tr>');
                    return;
                } else {
                    $('#datatable1 tbody').empty();
                    $.each(seatApplications, function (index, application) {
                        var row = '<tr>' +
                            '<td>' + application.user_name + '</td>' +
                            '<td>' + application.room_no + '</td>' +
                            '<td>' + application.seat_no + '</td>' +
                            '<td>' + application.building_name + '</td>' +
                            '<td>' + application.lease_start_date + '</td>' +
                            '<td>' + application.lease_end_date + '</td>' +
                            '<td>' + application.status + '</td>' +
                            '<td>' +
                            '<button class=' + 'btn btn-primary' + ' id=' + 'approve-button' + ' data-seat-allocation-id=' + application.seat_allocation_id + '>Approve</button>' +
                            '</td>' +
                            '</tr>';
                        $('#datatable1 tbody').append(row);
                    });
                }
            },
            error: function () {
                console.error('Ajax request for loading table data failed');
            }
        });
    }

    // Initial load of table data
    loadTableData();

    $('#datatable2').DataTable({
        bLengthChange: false,
        searching: false,
        responsive: true
    });

    $('#viewpendingApplications').on('click', '#approve-button', function (e) {
        e.preventDefault();

        var seatAllocationId = $(this).data('seat-allocation-id');

        // Perform your AJAX request or any other action based on the extracted seat_allocation_id
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: {
                action: 'room-approve',
                sa_id: seatAllocationId
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    showAlert('success', response.success);

                    // Reload the table data after a successful approval
                    loadTableData();
                } else {
                    showAlert('error', response.error);
                }
            },
            error: function () {
                console.error('Ajax request for seat approval failed');
            }
        });
    });
});


";


include '../templates/base.php';
