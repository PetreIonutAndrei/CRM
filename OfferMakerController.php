<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Offer;
use App\Entity\User;


class OfferMakerController extends AbstractController{
    /**
     * @Route ("/add_offers", methods={"GET","POST"}, name="add")
     * @param Request $request
     */

    public function addOffer(Request $request) {
        $userId = $request->getSession()->get('userId'); // luam din sesiune; daca cineva ajunge sa faca add task inseamna ca e deja logat(id-ul userului care e logat)
        $customerName = $request->request->get('customerName'); // luam informatiile din POST prin metoda request
        $offerDescription =$request->request->get('offerDescription');// luam informatiile din POST prin metoda request
        $price=$request->request->get('price');// luam informatiile din POST prin metoda request
        //ca sa adaugam oferta trebuie sa o cream deci vom folosi contructorul
        $avalability ='';
        $done = false;
        $comments = '';
        $offer = new Offer($userId,$customerName,$offerDescription,$price,$avalability, $comments, $done);
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($offer); //entitymanager
        $em->flush();
        //get_offer e lista de offerte
        return $this->redirectToRoute('get_offers');
    }
//    /**
//     * @Route("/get_offers", methods ={"GET"}, name = "get_offers")
//     * @param Request $request
//     * @return Response
//     */
    
    //vreu sa iau obiectul din baza de date sa-l prelucrez si sa-l afisez pe template (mappat pe ruta get_offer) model->controler->view
//    public function getOffers(Request $request){
//        $repo = $this->getDoctrine()->getRepository(Offer::class);
//        $offerId = $request->getSession()->get('userId'); 
//        $offers = $repo->findBy(['userId' => $userId]); 
//
//            
//        return $this-> render(
//                'OfferMaker.html.twig',//dupa render putem face un array de prop pe care sa le trimitem twig-ului
//                ['offers' => $offers] //offers din twig ia valuarea obiectului nostru
//                );
//    }
     /**
     * @Route("/get_offers", methods ={"GET"}, name = "get_offers")
     * @param Request $request
     * @return Response
     */
    public function getOffers(Request $request){
        $repo_offer = $this->getDoctrine()->getRepository(Offer::class);
        $repo_user = $this->getDoctrine()->getRepository(User::class);

        $userId = $request->getSession()->get('userId');
        $user = $repo_user->findOneByUserId(['userId'=>$userId]);
        $userRole = $user->getRole();
        $offers = $repo_offer->findAll();
        
        return $this-> render(
                'Offers.html.twig',
                ['offers' => $offers, 'userRole' => $userRole]
                );
    }
    /**
     * @Route("/delete_offer", methods={"POST"}, name="delete")
     * @param Request $request
     * return type
     */
    
    // 
    public function deleteOffer(Request $request){
        $repo = $this->getDoctrine()->getRepository(Offer::class);
        $offerId = $request->request->get('delete_offerId');
        $userId = $request->getSession()->get('userId');
        $offer = $repo->findOneBy(['offerId' => $offerId,
                                  'userId' => $userId
                                ]);
        $em = $this->getDoctrine()->getManager();
        
        $em->remove($offer); //entitymanager
        $em->flush();
        
        return $this->redirectToRoute('get_offers');
    }
    /**
     * @Route("/update", methods={"POST"}, name="update")
     * @param Request $request
     * return type
     */
    
    public function getOfferIdForUpdate(request $request){
        $offerId = $request->request->get('offerId');
        $userId = $request->getSession()->get('userId');
        $repo = $this->getDoctrine()->getRepository(User::class);

        $user = $repo->findOneBy(['userId' => $userId]);
        if($user->getRole() == 'offerMaker') {
        return $this->render('UpdateOffer.html.twig', ['offerId'=>$offerId]);
        }else {
        return $this->render('SalesPerson.html.twig', ['offerId'=>$offerId]);
        }       
    } 
    /**
     * @Route("/update_offer", methods={"POST"}, name="update_offer")
     * @param Request $request
     * return type
     */
    public function updateOffer(Request $request){
        $repo = $this->getDoctrine()->getRepository(Offer::class);
        $offer = $repo->findOneBy([
            'offerId' => $request->request->get('update_offerId'),
            'userId' => $request->getSession()->get('userId')
        ]);
        
        if(!empty($offer)) {
            if($request->request->get('offerDescription')!= null){
            $offer->setOfferDescription($request->request->get('offerDescription'));

            }
            if($request->request->get('price')!= null){
            $offer->setPrice($request->request->get('price'));
            }
            $em = $this->getDoctrine()->getManager();
            
            $em->flush();
        }
    return $this->redirect('/CRM/public/index.php/get_offers');
    }
}

