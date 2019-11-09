<?php


namespace App\Model\Entity;


use Cake\ORM\Entity;

class Country extends Entity
{
  public function _getCountrySpecialName(){
      return "The country name is: (" . $this->country_name . ")";
  }
}
