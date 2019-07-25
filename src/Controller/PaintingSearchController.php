<?php

namespace App\Controller;

use App\Manager\ElasticSearchQueryManager;
use App\Mapper\ElasticQueryMapper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Elasticsearch\ClientBuilder;

class PaintingSearchController extends BaseController
{
    /**
     * @Route("/painting/search", name="painting_search")
     */
    public function index(Request $request)
    {
        if ($request->getMethod() === 'POST') {

            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {

                $QueryManager = new ElasticSearchQueryManager();
                $resultData = $QueryManager->ProcessSearchRequest($request);
                return $this->json(
                    $resultData// This Returns Array of Processing Result
                    , $resultData['status_code']);
            } else {
                return $this->json([
                    'status_code' => Response::HTTP_BAD_REQUEST,
                    'msg' => 'Header of Content-Type: application/json is Required'
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return $this->json([
                "status_code" => Response::HTTP_BAD_REQUEST,
                "msg" => 'Post Method Should Be Used: used ' . $request->getMethod()
            ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * @Route("/painting/search/latest", name="painting_search_latest")
     */
    public function getter()
    {
        // Create Elastic Search Client
        $client = ClientBuilder::create()->build();
        $params = [
            'index' => 'yes_final',
            'body' => [
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ];
        // This gives the whole search result
        $elasticSearchResult = $client->search($params);
        // This is done for cost minimization
        $itemsArray = [];
        foreach ($elasticSearchResult['hits']['hits'] as $item) {
            array_push($itemsArray, $item['_source']);
        }
        $response = new Response($this->json([
            "data" => $itemsArray
        ]), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        // Allow all Websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}
