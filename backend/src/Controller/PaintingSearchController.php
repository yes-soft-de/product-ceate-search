<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Elasticsearch\ClientBuilder;

class PaintingSearchController extends AbstractController
{
    /**
     * @Route("/painting/search", name="painting_search")
     */
    public function index(Request $request)
    {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {

            // Create Elastic Search Client
            $client = ClientBuilder::create()->build();

            // Allocate JSON Object
            $data = json_decode($request->getContent(), true);

             $request->request->replace(is_array($data) ? $data : array());

            // region Should Constructions
            $should = [

            ];
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
                 $resultData
                ]
            );
        }
        else {
            return $this->json([
                    "msg" => "Welcome!"
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
            'index' => 'yes_new',
            'body' => [
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ];
        $response = $client->search($params);

        $fullJson = '[';
        $start = true;
        foreach ($response['hits']['hits'] as $node) {
            $str = $node['_source']['message'];
            if ($start){
                $fullJson = "$fullJson$str";
                $start = false;
            } else {
                $fullJson = "$fullJson,$str";
            }
        }
        $fullJson = "$fullJson]";

        $string = preg_replace('/[\x00-\x1F\x7F]/u', '', $fullJson);
        $myResponse = $this->json([
                'data' => json_decode( $string, true)
            ]
            , 200);
        $myResponse->headers->set('Access-Control-Allow-Origin', '*');
        $myResponse->headers->set('Content-Type', 'application/json');
        return $myResponse;
    }
}
