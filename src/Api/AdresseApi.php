<?php


namespace App\Api;


use GuzzleHttp\Client;

class AdresseApi
{
    public function getAdresse($adresse){
        $client = new Client();
        $response=$client->request('GET','https://api-adresse.data.gouv.fr/search/?q='.$adresse);
        $array=json_decode($response->getBody(),true);
        return $array;
    }
}