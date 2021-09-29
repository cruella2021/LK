<?php


class Route{


    function __construct()
    {
        $this->arraySample  = [
            '/^auth$/'       =>'auth',
            '/^main$/'       =>'main',
            '/^organization/'=>'listEmployees',
            '/^info$/'       =>'info',
            '/^auth$/'       =>'auth',
            '/^users$/'      =>'users',
            '/^roles$/'      =>'roles',
            '/^exit$/'       =>'exit',
            '/^contacts$/'   =>'contacts'
        ];    
    }

    public function getController($url){
        foreach( $this->arraySample as $Sampal=>$Controller ){
            if ( preg_match($Sampal,$url) ){
                return $Controller;
            }
        }
    }
}