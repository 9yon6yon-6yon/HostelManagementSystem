<?php
require('DatabaseHandler.php');
$pageTitle = "View Users";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'viewusers.php', 'label' => 'List of Users'],
];
$databaseHandler = new DatabaseHandler();
if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $user = $databaseHandler->getUserInfo($id);
    if ($user === NULL) {
        $content = "
        <div class='card pd-20 pd-sm-40'>
            <div class='row'>
                <div class='col-md'>
                    <div class='card bg-gray-200'>
                        <div class='card-body'>
                        <h5 class='card-body-title'>No information is available for this user</h5>
                        </div>
                    </div><!-- card -->
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- main card -->";
    } else {
        $formattedDate = date("M d, Y", strtotime($user['date_of_birth']));
        $tableRow = '';
        $tableRow .= "
                <h5 class='card-body-title'>{$user['name']}</h5> <p>{$user['mail']}</p>
                <p class='card-subtitle tx-normal mg-b-15'> DOB : {$formattedDate}</p>
                <p class='card-text'>{$user['phone_number']}</p>
                ";
        $pages =  [
            ['url' => 'dashboard.php', 'label' => 'Dashboard'],
            ['url' => 'viewusers.php', 'label' => 'List of Users'],
            ['url' => "viewusers.php?id={$user['id']}", 'label' => "{$user['name']}"]
        ];
        $content = "
    <div class='card pd-20 pd-sm-40'>
        <div class='row'>
            <div class='col-md'>
                <div class='card bg-gray-200'>
                    <div class='card-body'>
                   $tableRow
                    </div>
                </div><!-- card -->
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- main card -->";
    }
}
$users = $databaseHandler->getUsers();
$tableRows = '';
foreach ($users as $user) {
    $tableRows .= "<tr>
        <td>{$user['id']}</td>
        <td> <a href=\"viewusers.php?id={$user['id']}\" class=\"tx-inverse tx-14 tx-medium d-block\">{$user['name']}</a></td>
        <td>{$user['mail']}</td>
        <td>{$user['role']}</td>
        <td>" . ($user['verified'] ? 'Yes' : 'No') . "</td>
    </tr>";
}

$content .= "
<div class='row row-sm mg-t-20'>
        <div class='col-xl-8 card pd-20 pd-sm-40'>
            <h6 class='card-body-title'>View Users</h6>
            <div class='table-wrapper'>
                <table id='datatable1' class='table display responsive nowrap'>
                    <thead>
                        <tr>
                            <th class='wd-15p'>ID</th>
                            <th class='wd-15p'>Name</th>
                            <th class='wd-20p'>E-mail</th>
                            <th class='wd-15p'>Role</th>
                            <th class='wd-10p'>Verified</th>
                        </tr>
                    </thead>
                    <tbody>
                        $tableRows
                    </tbody>
                </table>
            </div><!-- table-wrapper -->
        </div><!-- card -->
        <div class='col-xl-4 mg-t-20 mg-xl-t-0 bg-white'>
            <div class='card pd-20 pd-sm-40 form-layout form-layout-4'>
                <div class='signin-logo tx-center tx-24 tx-bold tx-inverse'>Hostel Management <span
                        class='tx-info tx-normal'>admin</span></div>

                <form id='createUserForm'>
                    <div class='form-group'>
                        <input type='text' class='form-control' name='username' placeholder='Enter username'>
                    </div><!-- form-group -->
                    <div class='form-group'>
                        <input type='email' class='form-control' name='email' placeholder='Enter email address'>
                    </div><!-- form-group -->
                    <div class='form-group'>
                        <input type='password' class='form-control' name='password'
                            placeholder='Enter password / default is password'>
                    </div><!-- form-group -->
                    <div class='form-group'>
                        <select class='form-control select2' name='role' data-placeholder='Choose role'>
                            <option value='admin'> Admin</option>
                            <option value='student'> Student</option>
                            <option value='accounts'> Accounts</option>
                            <option value='provost'> Provost</option>
                            <option value='hallsuper'> Hall Super</option>
                        </select>
                    </div>

                    <button type='submit' class='btn btn-info btn-block'>Create</button>
                </form>
            </div>
        </div>
    </div>

";
$script = "$(function(){
    'use strict';
    $('.select2').select2({
        minimumResultsForSearch: Infinity
    });
    $('#datatable1').DataTable({
      responsive: true,
      language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
      }
    });

    $('#datatable2').DataTable({
      bLengthChange: false,
      searching: false,
      responsive: true
    });

    // Select2
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

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

});
";

include '../templates/base.php';
