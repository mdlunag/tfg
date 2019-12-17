<?php

class Redireccio{
    
    public static function redirigir($url){
        header('Location: '.$url,True, 301);
        exit();
        
    }
}