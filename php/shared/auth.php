<?php
    session_start();
    function isLoggedIn(){
       if(isset($_SESSION['isAdmin'])){
            return true;
       }
        else return false;
    }
?>