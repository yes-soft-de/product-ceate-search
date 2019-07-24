<?php

namespace App\Entity;

class ElasticSearchQuery
{
    private $query = [];

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    public function createQuery($indexName)
    {
        $this->query = [
            'index' => $indexName,
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [
                        ]
                    ]
                ]
            ]
        ];
    }

    public function addShouldQuery($field, $keyword)
    {
        if (is_null($this->query)) {
            $this->createQuery('yes_final');
        }

        array_push($this->query['body']['query']['bool']['should'], [
            'match' => [
                $field => $keyword
            ]
        ]);
    }

    public function addMustQuery($field, $keyword)
    {
        if (is_null($this->query)) {
            $this->createQuery('yes_final');
        }

        array_push($this->query['body']['query']['bool'], [
            'should' => [
                'match' => [
                    $field => $keyword
                ]
            ]
        ]);
    }

}