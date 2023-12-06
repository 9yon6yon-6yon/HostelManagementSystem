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
<div class='card pd-20 pd-sm-40'>
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
";
$script = "$(function(){
    'use strict';

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

  });";

include '../templates/base.php';
