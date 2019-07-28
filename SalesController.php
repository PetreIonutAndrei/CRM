<?php

namespace App\Controller; // defineste functii predefinite

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; //pachete specializate in aplicatii web
use Symfony\Component\HttpFoundation\Response; //pachete specializate in aplicatii web
use Symfony\Component\Routing\Annotation\Route; //pachete specializate in aplicatii web
use Symfony\Component\HttpFoundation\Request; //pachete specializate in aplicatii web
use App\Entity\User; //pachete specializate in aplicatii web
use App\Entity\Offer;
class SalesController extends AbstractController {
    
/**
     * @Route("/update_offer_sales", methods={"POST"}, name="update_offer_sales")
     * @param Request $request
     * return type
     */
public function updateOfferSales(Request $request){
        $repo = $this->getDoctrine()->getRepository(Offer::class);
        
        $offer = $repo->findOneBy([
            'offerId' => $request->request->get('update_offerId')]);
        
        if(!empty($offer)) {
            
            if($request->request->get('avalability')!= null){
            $offer->setAvalability($request->request->get('avalability'));
            }
            if($request->request->get('comments')!= null){
            $offer->setComments($request->request->get('comments'));
            }
            $em = $this->getDoctrine()->getManager();
            
            $em->flush();
        }
    return $this->redirect('/CRM/public/index.php/get_offers');
    }

}