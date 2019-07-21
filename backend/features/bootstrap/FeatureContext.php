<?php
/**
 * Created by PhpStorm.
 * User: TEC-GATE
 * Date: 7/21/2019
 * Time: 12:59 PM
 */

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Response;

class FeatureContext implements Context
{
    private $api_url = "localhost:8000";

    private $create_endpoint = "/createPainting";
    private $search_endpoint = "/search";
    private $latest_endpoint = "/latest/painting";
    private $delete_endpoint = "/deletePainting";
    private $update_endpoint = "/updatePainting";

    private $response_code = null;
    private $response_body = null;

    private $search_response = null;

    // region Painting Create

    /**
     * @Given /^the backend server is alive$/
     * @throws Exception
     */

    public function theBackendServerIsAlive()
    {
        $client = new GuzzleHttp\Client(['base_uri' => $this->api_url]);
        $res = $client->get('/');
        if ($res->getStatusCode() === 200) {
            return true;
        } else {
            throw new Exception('Error:' . $res->getStatusCode());
        }
    }

    /**
     * @When /^I Send JSON File Contains Data$/
     */
    public function iSendJSONFileContainsData()
    {
        $client = new GuzzleHttp\Client(['base_uri' => $this->api_url]);
        $response = $client->post($this->create_endpoint, [
            'json' => [
                "name" => "Black Day",
                "image_url" => "http://localhost:4200/assets/logo.png",
                "size" => "L",
                "medium" => "oil",
                "style" => "Cubism",
                "description" => "Another Paint",
                "category" => "Art"
            ]
        ]);
        $this->response_code = $response->getStatusCode();
        // TODO Fix This Error
        $this->response_body = json_decode($response->getBody()->getContents());
    }

    /**
     * @Then /^I Should get JSON with result_code equals to HTTP::OK$/
     * @throws Exception
     */
    public function iShouldGetJSONWithResult_codeEqualsToHTTPOK()
    {
        if ($this->response_code === Response::HTTP_OK) {
            return true;
        } else {
            echo $this->response_code;
            throw new Exception('Got Error Code: ' . $this->response_code);
        }

    }
    // endregion

    // region Search Test

    /**
     * @When /^i Search for Painting with Query Message "([^"]*)"$/
     * @param $arg1
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    public function iSearchForPaintingWithQueryMessage($arg1)
    {
        $client = new GuzzleHttp\Client([
            'base_uri' => $this->api_url,
        ]);

        $response = $client->request('POST', $this->search_endpoint, [
            'json' => ['name' => $arg1]
        ]);

        if ($response == null || $response === null) {
            throw new Exception('Null Data Response');
        } else if ($response->getStatusCode() === Response::HTTP_OK) {
            $this->response_body = $response;
            return true;
        } else {
            throw new Exception('Error While Connecting With Search API, Status Code: ' . $response->getStatusCode());
        }


    }



    /**
     * @When /^i Request Latest Painting$/
     */
    public function iRequestLatestPainting()
    {
        $client = new GuzzleHttp\Client([
            'base_uri' => $this->api_url
        ]);

        $res = $client->get($this->latest_endpoint);

        $this->response_code = $res->getStatusCode();

    }

    /**
     * @When /^I Send JSON File Contains Painting ID of (\d+)$/
     * @param $paintingID
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function iSendJSONFileContainsPaintingIDOf1($paintingID)
    {

        $client = new GuzzleHttp\Client([
            'base_uri' => $this->api_url
        ]);

        $res = $client->request("DELETE", $this->delete_endpoint, [
            "json" => ["id" => $paintingID]
        ]);

        $this->response_code = $res->getStatusCode();
    }

    /**
     * @When /^I Send JSON File Contains Data contains the Painting ID of (\d+)$/
     * @param $paintingID
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function iSendJSONFileContainsDataContainsThePaintingIDOf($paintingID)
    {

        $client = new GuzzleHttp\Client([
            'base_uri' => $this->api_url
        ]);

        $res = $client->request("PUT", $this->update_endpoint, [
            'json' => [
                "id" => $paintingID,
                "name" => "Black Day",
                "image_url" => "http://localhost:4200/assets/logo.png",
                "size" => "L",
                "medium" => "oil",
                "style" => "Cubism",
                "description" => "Another Paint",
                "category" => "Art"
            ]
        ]);

        $this->response_code = $res->getStatusCode();
    }

    /**
     * @Then /^i Should Get a StatusCode of (\d+)$/
     * @param $arg1
     * @return bool
     * @throws Exception
     */
    public function iShouldGetAStatusCodeOf($arg1)
    {
        if ($this->response_body->getStatusCode() === $arg1) {
            return true;
        } else {
            throw new Exception('Error, Got Error Code: ' . $this->response_code);
        }
    }
    // endregion


    // endregion
}