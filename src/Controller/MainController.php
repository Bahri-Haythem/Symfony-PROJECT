<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
 /**
  * @Route("/", name="home")
  */
 public function index()
 {
  //afficher la page pricipale
  return $this->render('main/index.html.twig', [
   'controller_name' => 'MainController',
  ]);
 }

}
