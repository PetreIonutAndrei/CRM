<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class UserController extends AbstractController {
    /**
     * @Route("signup", methods={"POST","GET"})
     * @param Request $request
     * @return Response
     */
    public function signUp(Request $request)
    {
        if(!$request->request->has('email')
            || !$request->request->has('psw')) {
                return $this->render('signup.html.twig');
            }
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();
        $email = $request->request->get('email');

        foreach($users as $u){
            if($email == $u->getEmail()){
                return new Response('This email was already used.'.' You can signup <a href="/CRM/public/index.php/signup">here</a> ');
            }   
        }

        $password = $request->request->get('psw');
        $role = $request->request->get('role');
        
        $user = new User($email, $password, $role);
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($user);
        $em->flush();

        return $this->render(
            '/login.html.twig',
            ['error' => '']
        );
    }
    
    /**
     * @Route("/login")
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        if (!$request->request->has('uname') ||
            !$request->request->has('psw')) {
                return $this->render(
                        '/login.html.twig',
                        ['error' => '']
                        );
            }
            
        $email = $request->request->get('uname');
        $password = $request->request->get('psw');
        
        $repo = $this->getDoctrine()->getRepository(User::class);
        
        $user = $repo->findOneBy(['email' => $email]);
        
        if(is_null($user)) {
            return $this->render(
                    '/login.html.twig',
                    ['error' => 'Invalid user']
            );
        }

        if(!$user->hasPassword($password)) {
            return $this->render(
                    '/login.html.twig',
                    ['error' => 'Invalid password']
            );
        }

        $request->getSession()->set('email', $email);
        $request->getSession()->set('userId', $user->getUserId());
        
    
            return $this->redirect('/CRM/public/index.php/get_offers');
        
    }
    
    /**
     * @Route("/logout")
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request) {
        $request->getSession()->invalidate();
        
        return $this->redirect('/CRM/public/index.php/login');
    }
}
