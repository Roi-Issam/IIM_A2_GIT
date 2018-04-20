<?php
session_start();
require('config/config.php');
require('model/functions.fn.php');

/*===============================
	Dashboard
===============================*/

if (isset($_POST['subject']) && !empty($_POST['subject'])){

    $text = $_POST['subject'];
    $user_id = $_SESSION['id'];

    comment($db, $user_id, $text);
}



 if(!isset($_SESSION) OR empty($_SESSION)){
	header('Location: login.php');
	exit();
}

$musics = listMusics($db);



include 'view/_header.php';
include 'view/dashboard.php';
include 'view/_footer.php';