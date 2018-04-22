<?php
session_start();
require('config/config.php');
require('model/functions.fn.php');

if (isset($_POST['SUBJECT']) && !empty($_POST['subject'])){

    $text = $_POST['subject'];
    $user_id = $_SESSION['id'];

    comment($db, $user_id, $text);
}


include 'view/_header.php';
include 'view/dashboard.php';
include 'view/_footer.php';