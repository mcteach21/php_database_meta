<?php
/**
 * mc@2021
 */
require_once 'dbconnection.class.php';

class Meta {
    private static $pdo = null;
    private static function init() {
        self::$pdo =  DbConnection::Instance();
    }

    public static function tables(){
        $sql='SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE table_schema=?';

/*        echo '<hr/>'.$sql.'<hr/>';*/

        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([SCHEMA_NAME]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function columns($table){
        $sql='SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema=? AND table_name = ?'; //AND column_key='PRI' ;
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([SCHEMA_NAME, $table]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function column_id($table){
        $sql='SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema=? AND table_name = ? AND column_key="PRI"' ;
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([SCHEMA_NAME, $table]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function column_id_name($table){
        return self::column_id($table)['COLUMN_NAME'];
    }

    public static function columns_names($table){
        $columns = self::columns($table);
        $columns_names=[];
        foreach ($columns as $column){
            array_push( $columns_names, $column['COLUMN_NAME']);
        }
        return $columns_names;
    }
}
(static function () {
    static::init();
})->bindTo(null, Meta::class)();

