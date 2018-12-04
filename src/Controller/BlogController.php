<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Commentaire;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
    * @Route("/profil", name="profil")
    */
    public function profilAction(Request $request)
    {
        $user = $this -> getUser();

        return $this->render('blog/profil.html.twig', [
            'user' => $user,
        ]);

        /*$user = $this -> getUser();
        //dump($user);
        //die();

        if($request->isMethod('POST') && 
        !empty($request -> get("lastname")) &&
        !empty($request -> get("firstname")) && 
        !empty($request -> get("username")) && 
        !empty($request -> get("password")) )
        {
            $hash = $this->get('security.password_encoder')->encodePassword($user, $request->request->get('password'));

            $user -> setFirstname($request -> get("firstname"));
            $user -> setLastname($request -> get("lastname"));
            $user -> setPassword($hash);
            $user -> setUsername($request -> get("username"));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
	    return $this->render('blog/profil.html.twig',[
            'user' => $user
        ]);*/
    }
}
