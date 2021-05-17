<?php
/**
 * mc@2021
 */
require_once 'params.inc.php';

class DbConnection
{
    private static $pdo=null;
    public static function Instance(){
        if(self::$pdo==null){
            try {
                self::$pdo = new PDO(DSN, USERNAME, PASSWORD, OPTIONS);
            }catch (Exception $e){
                echo 'Erreur PDO : '.$e->getMessage();
                die();
            }
        }
        return self::$pdo;
    }
}