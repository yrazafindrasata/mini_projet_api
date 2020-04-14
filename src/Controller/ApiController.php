<?php


namespace App\Controller;

use App\Api\AdresseApi;
use App\Api\MeteoApi;
use DateInterval;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Api\InseeApi;


class ApiController extends AbstractController
{
    /**
     * @Route("/region",name="region")
     */
    public function index(Request $request, InseeApi $inseeApi)
    {
        if (!$request->hasSession() || !($session = $request->getSession()))
        {
            $session = $request->getSession();
            $dateExpire =$session ->get('dateExpire');
            if(new DateTime()>$dateExpire){
                $token = $inseeApi->getToken();
                $session->set('token',$token);
            }else{
                $token = $session ->get('token');
            }
        }
        else{
            $session = new Session();
            $token = $inseeApi->getToken();
            $session->set('token',$token);
            $dateExpire = new DateTime();
            date_add($dateExpire, date_interval_create_from_date_string("604800 secs"));
            $session->set('dateExpire',$dateExpire);

        }
        $dateExpire = new DateTime();
        date_add($dateExpire, date_interval_create_from_date_string("604800 secs"));


        $region = $inseeApi->getRegion(75, $token);

        return $this->render('base.html.twig',[
            'region'=> $region
        ]);
    }


    /**
     * @Route("/search",name="search")
     */
    public function search(Request $request)
    {
        return $this->render('Search.html.twig');
    }

    /**
     * @Route("/result",name="result", methods="GET")
     */
    public function result(Request $request, AdresseApi $adresseApi, MeteoApi $meteoApi)
    {
        $rue = $request->query->get("search_form");
        $features = $adresseApi->getAdresse($rue);
        $coordinates = $features['features'][0]['geometry']['coordinates'];
        $meteo = $meteoApi->getMeteo($coordinates);
        return $this->render('result.html.twig',[
            'meteo' => $meteo,
            'place' => $rue
        ]);
    }
}