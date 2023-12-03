<?php
require('DatabaseHandler.php');
$pageTitle = "View Users";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'viewusers.php', 'label' => 'List of Users'],
];
$databaseHandler = new DatabaseHandler();
$users = $databaseHandler->getUsers();
$tableRows = '';
foreach ($users as $user) {
    $tableRows .= "<tr>
        <td>{$user['id']}</td>
        <td>{$user['name']}</td>
        <td>{$user['mail']}</td>
        <td>{$user['role']}</td>
        <td>" . ($user['verified'] ? 'Yes' : 'No') . "</td>
    </tr>";
}

$content = "
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
