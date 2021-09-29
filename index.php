<?php

    session_start();

    include_once('init.php');
     
    $url = $_GET['querysystemyrl'] ?? '';
    $url = empty($url)? 'main': $url;
        
    if ( !isset($_SESSION['User']) ){
        $url = 'auth';
    }

    if ( $url ==='main' and  isset($_SESSION['id_1c']) and empty($_SESSION['Admin']) ){

        $Fields = ['id_1c' => $_SESSION['id_1c']];
        $connect_1c = New Request_to_1c();
        $Answer1C = $connect_1c->response('GetPathEmployee',$Fields);
        
        if ( isset($Answer1C->err) ){
            $cont = new Controller('main',[]);
            echo $cont->html;
            print_r($Answer1C->err);    
            exit();
        }else{
            $params = ['organization',$Answer1C->id_organisation,$Answer1C->id_subnet,$Answer1C->id_employee];
            $cont = new Controller('listEmployees',$params);
            
            echo $cont->html;
        }
        
    }else{
    
        $route = new Route();
        $nameController = $route->getController($url);

        $params =  explode('/',$url);
        $cont = new Controller($nameController,$params);
            
        echo $cont->html;
    }
    
?>
