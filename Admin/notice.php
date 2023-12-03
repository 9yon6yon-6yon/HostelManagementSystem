<?php
require('DatabaseHandler.php');
$pageTitle = "Notice";
$pages = [
    ['url' => 'dashboard.php', 'label' => 'Dashboard'],
    ['url' => 'notice.php', 'label' => 'Notice'],

];

$databaseHandler = new DatabaseHandler();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $notice = $databaseHandler->getNotice($id);
}
$content = '';
$script = "";


include '../templates/base.php';