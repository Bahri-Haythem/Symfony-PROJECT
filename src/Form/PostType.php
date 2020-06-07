<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
 public function buildForm(FormBuilderInterface $builder, array $options)
 {
  //utiliser FormBuilder pour creer la form des posts
  $builder
   ->add('title')
   ->add('text')
   ->add("save", SubmitType::class, [
    "attr" => [
     'class' => "btn btn-primary float-right",
    ],
   ])
  ;
 }

 public function configureOptions(OptionsResolver $resolver)
 {
  $resolver->setDefaults([
   'data_class' => Post::class,
  ]);
 }
}
