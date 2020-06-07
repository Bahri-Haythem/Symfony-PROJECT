<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{
 /**
  * @Route("/", name="index")
  */
 public function index(PostRepository $postRepository)
 {
  // rècuperer tous les posts
  $posts = $postRepository->findAll();

  return $this->render('post/index.html.twig', [
   'posts' => $posts,
  ]);
 }
 /**
  * @Route("/create", name="create")
  */
 public function create(Request $request)
 {
  //creer un post
  $post = new Post();
  $form = $this->createForm(PostType::class, $post);
  $form->handleRequest($request);
  //si on clique sur submit
  if ($form->isSubmitted()) {
   //on cree le entity manager
   $em = $this->getDoctrine()->getManager();
   //on ajoute le post a la base
   $em->persist($post);
   $em->flush();
   //affiche de message post created
   $this->addFlash("add", "post created");
   //redirection vers les posts
   return $this->redirect($this->generateUrl("post.index"));
  }
  return $this->render("post/create.html.twig", [
   "form" => $form->createView(),
  ]);
 }
/**
 * @Route("/show/{id}", name="show")
 */
 public function show(Post $post)
 {
  //$post = $postRepository->find($id);
  //afficher un seul post
  return $this->render("post/show.html.twig", [
   "post" => $post,
  ]);
 }
 /**
  * @Route("/delete/{id}", name="remove")
  */
 public function remove(Post $post)
 {
  //on cree le entity manager
  $em = $this->getDoctrine()->getManager();
  //on supprime le post
  $em->remove($post);
  //valider la supression dans la base
  $em->flush();
  //afficher le msg post deleted
  $this->addFlash("remove", "post deleted");
  return $this->redirect($this->generateUrl("post.index"));
 }
}
