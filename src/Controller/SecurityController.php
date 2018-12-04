<?php

namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Tests\Functional\Bundle\CsrfFormLoginBundle\Form\UserLoginType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;

class SecurityController extends Controller
{
    /**
    * @Route("/login", name="login")
    */
    public function loginAction(AuthenticationUtils $authUtils)
    {		
		$error = $authUtils->getLastAuthenticationError();
		$lastUsername = $authUtils->getLastUsername();
	
	    return $this->render('security/login.html.twig', [
			'last_username' => $lastUsername,
			'error'         => $error,
	    ]);
    }
     
    /**
     * @Route ("/register", name="register")
     */
    public function registerAction(Request $request){
        if($request -> isMethod('POST')){
            $data = $request->request->all();
            if (!empty($data['lastname']) && !empty($data['firstname']) && !empty($data['username']) && !empty($data['password']) ){
                $user = new User();
                
                $hash = $this->get('security.password_encoder')->encodePassword($user, $request->request->get('password'));
            
                $user -> setFirstname($request -> get("firstname"));
                $user -> setLastname($request -> get("lastname"));
                $user -> setPassword($hash);
                $user -> setUsername($request -> get("username"));
                $user -> setRole(array('ROLE_USER'));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                
                return $this->redirectToRoute('login');
            }
        }
        return $this -> render('security/register.html.twig');
    }
     
    /**
    * @Route("/logout", name="logout")
    */
    public function logoutAction()
    {

    }
     
    /**
    * @Route("/profil", name="profil")
    */
    public function profilAction(Request $request)
    {
        /*$user = $this -> getUser();

        return $this->render('blog/profil.html.twig', [
            'user' => $user,
        ]);*/

        $user = $this -> getUser();
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
        ]);
    }
	
} 