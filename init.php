<?php
    include_once 'base/class/tdata.class.php';
    include_once 'base/class/db.class.php';
    include_once 'base/ioc/ioc.class.php';
    include_once 'base/config/config.php';
    include_once 'base/controller/baseController.php';
    spl_autoload_register(function($class_name)
    {
        $file='controller/'.$class_name.'.php';
        if(file_exists($file))
        {
            require_once 'controller/'.$class_name.'.php';
        }
        else
        {
            $tdata=new tdata();
            $tdata->setTData('error','not fond!');
            $tdata->showInJson();
            exit(1);
        }
    });
    $arr=explode('/',$_SERVER['REQUEST_URI']);
    $controller=isset($arr[2])&&$arr[2]!=''?$arr[2].'Controller':'homeController';
    $action=isset($arr[3])?$arr[3]:'index';
?>