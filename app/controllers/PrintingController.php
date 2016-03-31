<?php

class PrintingController extends BaseController {


    /**
     * Printing call to SmartSource
     *
     * @return Response
     */
    public function callPrint()
    {
    	$input = Input::all();
        $client = new \GuzzleHttp\Client();
        $response = $client->get($input['url']);
        $xml = $response->xml();
        //echo $response->getBody();
        return $xml->printURL;
    }

}