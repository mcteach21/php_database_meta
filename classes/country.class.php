<?php 
/**
* class generated from database
* @table('country')
*/
class Country {
   private $code;
   private $name;
   private $continent;
   private $region;
   private $surfacearea;
   private $indepyear;
   private $population;
   private $lifeexpectancy;
   private $gnp;
   private $gnpold;
   private $localname;
   private $governmentform;
   private $headofstate;
   private $capital;
   private $code2;


   public function __construct($code, $name, $continent, $region, $surfacearea, $indepyear, $population, $lifeexpectancy, $gnp, $gnpold, $localname, $governmentform, $headofstate, $capital, $code2){
      $this->code = $code;
      $this->name = $name;
      $this->continent = $continent;
      $this->region = $region;
      $this->surfacearea = $surfacearea;
      $this->indepyear = $indepyear;
      $this->population = $population;
      $this->lifeexpectancy = $lifeexpectancy;
      $this->gnp = $gnp;
      $this->gnpold = $gnpold;
      $this->localname = $localname;
      $this->governmentform = $governmentform;
      $this->headofstate = $headofstate;
      $this->capital = $capital;
      $this->code2 = $code2;
   }

   public function __get($name){
      return $this->$name;
   }
   public function __set($name, $value){
      $this->name = $value;
   }


}