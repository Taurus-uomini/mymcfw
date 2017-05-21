<?php
    include_once('init.php');
    $ioc=new ioc();
    $c=$ioc->get($controller);
    $c->$action();
?>