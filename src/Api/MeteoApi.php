<?php


namespace App\Api;


use GuzzleHttp\Client;

class MeteoApi
{
    public function getMeteo($coordinates){
        $client = new Client();
        $response=$client->request('GET','api.openweathermap.org/data/2.5/weather?lat='.(string)$coordinates[0].'&lon='.(string)$coordinates[1].'&APPID=503fca9ec103dbc35b65bbf05dafa382');
        $array=json_decode($response->getBody(),true);
        return $array;
    }

}