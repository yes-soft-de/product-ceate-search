<?php

namespace App\Repository;

use Elasticsearch\ClientBuilder;

class ElasticSearchRepo
{
    private $searchClient;

    public function __construct()
    {
        $this->searchClient = $this->getSearchClient();
    }

    public function startSearching($elasticQuery)
    {
        return $this->searchClient->search($elasticQuery);
    }

    public function getSearchClient()
    {
        return ClientBuilder::create()->build();
    }
}
