<?php 
/**
* class generated from database
* @table('city')
*/
class City {
   private $id;
   private $name;
   private $countrycode;
   private $district;
   private $population;


   public function __construct($id, $name, $countrycode, $district, $population){
      $this->id = $id;
      $this->name = $name;
      $this->countrycode = $countrycode;
      $this->district = $district;
      $this->population = $population;
   }

   public function __get($name){
      return $this->$name;
   }
   public function __set($name, $value){
      $this->name = $value;
   }


}