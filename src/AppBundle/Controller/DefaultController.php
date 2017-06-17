<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post as Post;
use AppBundle\Entity\Comment as Comment;
use AppBundle\Form\CommentType as CommentType;
use AppBundle\Form\PostType as PostType;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime as DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request){


        $request->setLocale('pl');
        $em = $this->getDoctrine()->getRepository('AppBundle:Post');

        $news = $em->createQueryBuilder('n')
        ->orderBy('n.createdAt', 'DESC')
        ->getQuery()
        ->setMaxResults(5)
        ->getResult();

        return $this->render('default/index.html.twig', [
            'news' => $news
            ]);
    }

    /**
    * @Route("/post", name="post")
    */
    public function showpostsAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT post FROM AppBundle:Post post";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
   
        return $this->render('default/post.html.twig', [
            'posts' => $pagination
            ]);
    }

    /**
    * @Route("post/article/{id}", name="article")
    */
    public function showArticleAction(Post $article, Request $request)
    {
        // Przechwycenie danych (z formularza) - request jest za to odpowiedzialny

        $form = null;

////////////////////////////////////// DLA ZALOGOWANYCH UŻYTKOWNIKÓW ////////////////////////////////////

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
            //Persist - tylko na potrzeby doctrine, a flush - do bazy danych

                $this->addFlash('notice', 'Dodano komentarz');
                return $this->redirectToRoute('article', array('id' => $article->getID()));
            }
        }

        return $this->render('default/article.html.twig', [
            'article' => $article,
            'form'=> is_null($form) ? $form : $form->createView()
            ]);
    }

    /**
    * @Route("/post-new", name="new_article")
    *
    */
    public function newPostAction(Request $request)
    {
        $form = null;
        $newPost = new Post();
        $form = $this->createForm(PostType::class, $newPost);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($newPost);
            $em->flush();

            $this->addFlash('notice', 'Wstawiono nowy post');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/insert_article.html.twig', [
            'form' => is_null($form) ? $form : $form->createView()

            ]);
    }


}
