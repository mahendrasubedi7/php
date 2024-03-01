<?php
session_start();
if(!isset($_SESSION['user']['id']))
{
    header('Location:../auth/index.php');
}