<?php


namespace App\Model\Table;

use Cake\ORM\Table;

class CountriesTable extends Table
{

    public function initialize(array $config)
    {
        $this->setEntityClass('App\Model\Entity\Country');
        parent::initialize($config); // TODO: Change the autogenerated stub
    }
}
