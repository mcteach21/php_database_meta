<?php
/**
 * mc@2021
 */
require_once 'db/meta.class.php';


class MetaGenerator
{
    const CLASS_REP = 'classes/';
    public static $mapping = [];

    public static function init(){
        self::$mapping=[];

        $directory =  ROOT.'\classes\\';
        $directory_files = array_diff(scandir($directory), array('..', '.'));

        foreach ($directory_files as $file){
            if (!unlink($directory.$file)) {
                echo ("$file cannot be deleted due to an error");
            }
            else {
                //echo ("$file has been deleted");
            }
        }
    }

    public static function create_mapping_class($classe, $table){

        $columns = Meta::columns($table);

        $content='';
        $columns_names=[];
        foreach ($columns as $column){
            $content .='   private $'.strtolower($column['COLUMN_NAME']).';'.PHP_EOL;

            array_push( $columns_names, strtolower($column['COLUMN_NAME']));
        }
        $content_construct ='   public function __construct($'.implode(', $',$columns_names).'){'.PHP_EOL;
        foreach ($columns_names as $column_name) {
            $content_construct .='      $this->'.$column_name.' = $'.$column_name.';'.PHP_EOL;
        }
        $content_construct .='   }';

        $content_magic  ='   public function __get($name){'.PHP_EOL;
        $content_magic .='      return $this->$name;'.PHP_EOL;
        $content_magic .='   }'.PHP_EOL;
        $content_magic .='   public function __set($name, $value){'.PHP_EOL;
        $content_magic .='      $this->name = $value;'.PHP_EOL;
        $content_magic .='   }'.PHP_EOL;


        $class_name = ucfirst($classe);
        $code = "<?php 
/**
* class generated from database
* @table('".strtolower($table)."')
*/
class $class_name {
".$content.PHP_EOL."
".$content_construct.PHP_EOL."
".$content_magic.PHP_EOL."
}";




        $file_name = self::CLASS_REP.strtolower($class_name).'.class.php' ;
        file_put_contents($file_name,$code);

        self::$mapping[strtolower($table)] = $class_name;
    }

    public static function mapped_class($table){

       if (!isset(self::$mapping[$table])){
            return null;
       }
       return self::$mapping[$table];
    }
    public static function mapped_table($class){
        $table = ''; //strtolower($class);

        $directory =  ROOT.'\classes\\';
        $directory_files = array_diff(scandir($directory), array('..', '.'));

        foreach ($directory_files as $file){
            if(strtolower(str_replace('.class.php','', $file))==strtolower($class)) {
                $section = file_get_contents($directory . $file, FALSE, NULL, 5, 100);
                preg_match("/@table\((.*?)\)/", $section, $matches);

                $table =  $matches[1];
                break;
            }
        }
        return $table;
    }


}