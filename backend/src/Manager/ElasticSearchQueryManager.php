<?php
/**
 * Created by PhpStorm.
 * User: TEC-GATE
 * Date: 7/23/2019
 * Time: 2:16 PM
 */

namespace App\Manager;

use App\Mapper\ElasticQueryMapper;
use App\Repository\ElasticSearchRepo;

class ElasticSearchQueryManager
{
    private $searchRepo;

    public function __construct()
    {
        $this->searchRepo = new ElasticSearchRepo();
    }

    /*
     * INFO: the Header and Request Code are OK, what remains in checking 'data' field
     */
    public function ProcessSearchRequest($request): array
    {
        // region Allocate JSON Object and Check for 'query' field
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());

        if (!array_key_exists('query', $data)) {
            return [
                "status_code" => "401",
                "msg" => "query field does not exist"
            ];
        }

        // endregion

        // region Create Query Client Based on REQUEST: {"query": "Mohammad Al Kalaleeb 24"}
        $elasticQuery = new ElasticQueryMapper();
        $elasticQuery->createIndexQuery('yes_final');

        $keywords = explode(' ', $data["query"]);
        foreach ($keywords as $value) {
            $elasticQuery->addShouldQuery('name', $value);
        }
        // endregion

        $elasticSearchResult = $this->searchRepo->startSearching($elasticQuery->getFullQuery());

        return [
            'status_code' => 200,
            'data' => $this->cleanResponse($elasticSearchResult)
        ];
    }


    private function cleanResponse($response)
    {
        $resultData = [];
        foreach ($response['hits']['hits'] as $node) {
            $jsonObject = $node['_source'];
            array_push($resultData, $jsonObject);
        }
        return $resultData;
    }
}