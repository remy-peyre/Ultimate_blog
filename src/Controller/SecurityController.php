<?php
 namespace App\Controller;
 use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Tests\Functional\Bundle\CsrfFormLoginBundle\Form\UserLoginType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
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
                $user -> setFirstname($this -> removeAccents($request->request->get('firstname')));
                $user -> setLastname($this -> removeAccents($request->request->get('lastname')));
                $user -> setUsername($request->request->get('username'));
                $user -> setPassword($hash);
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
	
	public function removeAccents($text) {
        $alphabet = array(
            'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
            'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
            'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
            'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
            'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
            'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
            'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
        );
 
        $text = strtr ($text, $alphabet);
 
        // replace all non letters or digits by -
        $text = preg_replace('/\W+/', '-', $text);
 
        return $text;
    }
} 