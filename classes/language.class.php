<?php 
/**
* class generated from database
* @table('countrylanguage')
*/
class Language {
   private $countrycode;
   private $language;
   private $isofficial;
   private $percentage;


   public function __construct($countrycode, $language, $isofficial, $percentage){
      $this->countrycode = $countrycode;
      $this->language = $language;
      $this->isofficial = $isofficial;
      $this->percentage = $percentage;
   }

   public function __get($name){
      return $this->$name;
   }
   public function __set($name, $value){
      $this->name = $value;
   }


}