<?php
    setcookie('login', '', time()-1 );
    header('Location:'.$_SERVER['HTTP_REFERER']);
?>