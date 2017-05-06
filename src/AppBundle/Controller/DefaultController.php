<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post as Post;
use AppBundle\Entity\Comment as Comment;
use AppBundle\Form\CommentType as CommentType;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request){

        $request->setLocale('pl');
        
        return $this->render('default/index.html.twig', []);
    }

    /**
    * @Route("/post", name="post")
    */
    public function postsAction(){

        $manager = $this->getDoctrine()->getManager();
        $posts = $manager->createQueryBuilder()
        ->from('AppBundle:Post', 'p')
        ->select('p')
        ->setMaxResults(5)
        ->getQuery()
        ->getResult();
    
        return $this->render('default/post.html.twig', [
            'posts' => $posts
            ]);
    }

    /**
    * @Route("post/article/{id}", name="article")
    */
    public function showPostAction(Post $article, Request $request)
    {
        // Przechwycenie danych (z formularza) - request jest za to odpowiedzialny

        $form = null;

///////////////////////////////////// DLA ZALOGOWANYCH UŻYTKOWNIKÓW ///////////////////////////////////////////////

        if ($user = $this->getUser()) {
            
            $comment = new Comment();
            $comment->setPost($article);
            $comment->setUser($user);

            //FORMULARZ - doctrine:generate:form AppBundle:Comment
            $form = $this->createForm(CommentType::class, $comment);
            //Obsługa, walidacja
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
            //Persist - na potrzeby doctrine, a flush - do bazy danych

                $this->addFlash('success', 'Dodano komentarz');
                return $this->redirectToRoute('article', array('id' => $article->getID()));
            }
        }

        return $this->render('default/article.html.twig', [
            'article' => $article,
            'form'=> is_null($form) ? $form : $form->createView()
            ]);
    }

}
