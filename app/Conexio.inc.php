<?php

class Conexio {

    private static $conexio;

    public static function obrir_conexio() {

        if (!isset(self::$conexio)) {
            try {
                include_once 'config.inc.php';

                self::$conexio = new PDO('mysql:host=' . NOM_SERVIDOR . ';dbname=' . NOM_BD, NOM_USUARI, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
                self::$conexio->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conexio->exec("SET CHARACTER SET utf8");
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage() . "<br>";
                die();
            }
        }
    }

    public static function tancar_conexio() {
        if (isset(self::$conexio)) {
            self::$conexio = null;
        }
    }

    public static function obtenir_conexio() {

        return self::$conexio;
    }

}
