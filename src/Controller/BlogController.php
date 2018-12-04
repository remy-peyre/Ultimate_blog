<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Post;
use App\Entity\Comment;

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
     * @Route("/create-post", name="create-post")
     */
    public function createPostAction(Request $request)
    {
        $user = $this -> getUser();
        if($request->isMethod('POST')){
            $file = $request -> files-> get("picture") ;
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            
            try {
                $file->move(
                    $this->getParameter('post_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                return $this->redirectToRoute('create-post');
            }

            $post = new Post();
            $post -> setTitle($request -> get("title"));
            $post -> setContent($request -> get("content"));
            $post -> setPicture($fileName);
            $post -> setUsers($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }
         return $this -> render('blog/create-post.html.twig',[
            'user' => $user
        ]);
    }
     
    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
