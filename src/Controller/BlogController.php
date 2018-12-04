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
        $user = $this -> getUser();
        $post =  $this->getDoctrine()->getRepository(Post::class) -> findBy([], ['id' => 'DESC']);

	    return $this->render('blog/index.html.twig',[
            'user' => $user,
            'post' => $post
        ]);
    }

    /**
     * @Route("/create-post", name="create-post")
     */
    public function createPostAction(Request $request)
    {
        $user = $this -> getUser();
        if($request->isMethod('POST'))
        {
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
     * @Route("/post/{id}", name="show_post")
     */
    public function postAction($id)
    {
        $user = $this->getUser();
        $post =  $this->getDoctrine()->getRepository(Post::class) -> findById($id);

        if($post === NULL || empty($post) )
        {
            return $this->redirectToRoute('homepage');
        } else {
            return $this->render('blog/post.html.twig',[
                'user' => $user,
                'post' => $post
            ]);          
        }
    }

    /**
     * @Route("/create-comment/{id}", name="create-comment")
     */
    public function createCommentAction(Request $request, $id)
    {
        $user = $this -> getUser();

        if($request -> isMethod('POST'))
        {
            $post =  $this->getDoctrine()->getRepository(Post::class) -> findOneById($id); 
            $comment = new Comment();
            $comment -> setContent($request -> get("content"));
            $comment -> setUsers($user);
            $comment -> setPost($post);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('show_post', array('id' => $id));
        } else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
    
}
