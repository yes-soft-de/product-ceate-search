<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Elasticsearch\ClientBuilder;

class PaintingSearchController extends AbstractController
{
    /**
     * @Route("/painting/search", name="painting_search")
     */
    public function index(Request $request) {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            // Create Elastic Search Client
            $client = ClientBuilder::create()->build();
            // Allocate JSON Object
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
            // region Should Constructions
            $should = [];
            $keywords = explode(' ', $data["query"]);
            foreach ($keywords as $value) {
                $valueMatch = ['match' => [
                    'message' => $value
                ]];
                array_push($should, $valueMatch);
            }
            // endregion
            $params = [
                'index' => 'yes',
                'body' => [
                    'query' => [
                        'bool' => [
                            'should' => [
                                $should
                            ]
                        ]
                    ]
                ]
            ];
            $response = $client->search($params);
            $resultData = [];
            foreach ($response['hits']['hits'] as $node) {
                $jsonObject = json_decode($node['_source']['message']);
                array_push($resultData, $jsonObject);
            }
            return $this->json([
                    "data" => $resultData
                ]
            );
        } else {
            return $this->json([
                    "msg" => "Welcome To GitHub!"
                ]
            );
        }
    }
    /**
     * @Route("/painting/search/latest", name="painting_search")
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
