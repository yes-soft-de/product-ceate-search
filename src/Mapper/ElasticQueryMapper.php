<?php
/**
 * Created by PhpStorm.
 * User: TEC-GATE
 * Date: 7/23/2019
 * Time: 1:23 PM
 */

namespace App\Mapper;


use App\Entity\ElasticSearchQuery;

class ElasticQueryMapper
{
    private $query;

    public function createIndexQuery($indexName){
        $this->query = new ElasticSearchQuery();
        $this->query->createQuery($indexName);

    }

    public function addMustQuery($fieldName, $keyword){
        $this->query->addMustQuery($fieldName, $keyword);
    }

    public function addShouldQuery($fieldName, $keyword){
        $this->query->addShouldQuery($fieldName, $keyword);
    }

    public function getFullQuery(){
        return $this->query->getQuery();
    }
}