<?php
session_start();
try{
    $_SESSION['login'];
}
catch (Exception $e){
    header('Location: ../home/login.html' );

}
//{
//
//    echo false;
//}
?>
