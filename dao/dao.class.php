<?php
/**
 * mc@2021
 */
require_once 'idao.interface.php';
require_once 'db/dbconnection.class.php';
require_once 'db/meta.class.php';
require_once 'db/generator.class.php';

 class Dao implements IDao
{
    private $pdo;
    private $table;
    private $mapped_class;

    private $columns;
    private $columns_names;

    public function __construct($table)
    {
        $this->pdo = DbConnection::Instance();
        $this->table = $table;
        $this->mapped_class = MetaGenerator::mapped_class($table);

        $this->columns = Meta::columns($table);
        $this->columns_names = Meta::columns_names($table);
    }

    public function all()
    {
        $items = array();
        $table_items = $this->pdo->query('SELECT * FROM '.$this->table)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($table_items as $table_item){
            $item=$this->map_table_item($table_item);
            array_push($items, $item);
        }
        return $items;
    }

    public function get($id)
    {
        $item = null;
        $column_id_name = Meta::column_id($this->table)['COLUMN_NAME'];

        $stmt = $this->pdo->prepare('SELECT * FROM '.$this->table.' WHERE '.$column_id_name.'=?');
        $stmt->execute([$id]);
        $table_item = $stmt->fetch();
        if($table_item!=null){
            $item = $this->map_table_item($table_item);
        }
        return $item;
    }

    public function add($item)
    {

        $sql = $this->add_item_sql($item);
        return $this->pdo->exec($sql);
    }

    public function update($item)
    {
        $sql = $this->update_item_sql($item);
        $stmt = $this->pdo->prepare($sql);

        $column_id_name = Meta::column_id_name($this->table);
        $args=[];
        foreach ($this->columns_names as $name)
            if($name!=$column_id_name)
                array_push($args, $item->$name);

        array_push($args, $item->$column_id_name);
        return $stmt->execute($args);
    }

    public function delete($item)
    {
        if($item==null)
            return;

        $column_id_name = Meta::column_id_name($this->table);
        $sql = 'DELETE FROM '.$this->table.' WHERE '.$column_id_name.' = ?';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$item->$column_id_name]);
    }

    private function map_table_item($table_item){
        $args =[];
        foreach ($this->columns_names as $column_name)
            array_push($args, $table_item[$column_name]);

        require_once 'classes/'.strtolower($this->mapped_class).'.class.php';
        return new  $this->mapped_class(...$args);
    }

     private function add_item_sql($item)
     {
        $sql = '';
        foreach ($this->columns as $column){
            $type_separator = ($column['DATA_TYPE']=='int')?'':'\'';
            $name = $column['COLUMN_NAME'];
            $sql .= ($sql==''?'INSERT INTO '.$this->table.' VALUES  (':', ').$type_separator.$item->$name.$type_separator;
        }
        $sql .= ')';
        return $sql;
     }
     private function update_item_sql($item)
     {
         $column_id_name = Meta::column_id_name($this->table);
         $sql = '';
         foreach ($this->columns as $column){
             $name = $column['COLUMN_NAME'];
             if($name!=$column_id_name)
                $sql .= ($sql==''?'UPDATE '.$this->table.' SET ':', ').$name.' = ?';
         }
         $sql .= ' WHERE '.$column_id_name.'=?';
         return $sql;
     }

 }