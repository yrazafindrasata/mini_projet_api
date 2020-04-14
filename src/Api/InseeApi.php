<?php


namespace App\Api;
use GuzzleHttp\Client;


class InseeApi
{
    public function getToken()
    {
        $client = new Client();
        $response=$client->request('POST','https://api.insee.fr/token?grant_type=client_credentials', [
            'headers' => [ 'Authorization' => "Basic MjB0b3NlNFh5T3ZlWlFEY3hOcWJoNjZMTVJrYTpfTGNfV0h2RWZZSldKVkZKSG9SSktWUEhyODRh",'grant_type' => 'client_credentials',]
        ]);
        $array=json_decode($response->getBody(),true);
        $token=$array['access_token'];
        return $token;
    }

    public function getRegion($id,$token)
    {
        $client = new Client();
        $response=$client->request('GET','https://api.insee.fr/metadonnees/nomenclatures/v1/geo/region/'.$id, [
            'headers' => [ 'Authorization' => "Bearer ".$token]
        ]);
        $array=json_decode($response->getBody(),true);
        return $array;
    }

}