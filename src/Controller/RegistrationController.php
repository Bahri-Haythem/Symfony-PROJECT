<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
 /**
  * @Route("/register", name="register")
  */
 public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
 {
  //on cree une form avec form builder
  $form = $this->createFormBuilder()
   ->add('username')
   ->add('password', RepeatedType::class, [
    'type'           => PasswordType::class,
    'required'       => true,
    'first_options'  => ['label' => 'password'],
    'second_options' => ['label' => 'repeat password'],
   ])
   ->add('register', SubmitType::class, [
    "attr" => [
     'class' => "btn btn-success float-right",
    ],
   ])
   ->getForm();
  $form->handleRequest($request);
  // si l'utilisateur submit la form
  if ($form->isSubmitted()) {
   //on recupère les données de la form
   $data = $form->getData();
   $user = new User();
   $user->setUsername($data['username']);
   $user->setPassword(
    //on doit ici crypter le mot de passe
    $passwordEncoder->encodePassword($user, $data["password"])
   );
   //on cree le entity manager
   $em = $this->getDoctrine()->getManager();
   //on ajoute le user a la base
   $em->persist($user);
   $em->flush();
   //redirection vers login
   return $this->redirect($this->generateUrl("app_login"));
  }
  //affichage de la vue de registration
  return $this->render('registration/index.html.twig', [
   'form' => $form->createView(),
  ]);
 }
}
