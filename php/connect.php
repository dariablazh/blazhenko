<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'dzst');

  if (!$conn) {
        die('Error connect to DataBase');
    }
?>