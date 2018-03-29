<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('user/index.html.twig');
    }
    public function nuevoAction(Request $request )
	{
	  $user = new User();
      $form =  $this->createForm(UserType::class);
      $form -> handleRequest($request);
      if ($form ->isSubmitted() && $form->isValid() ){
      	$user = $form->getData(); 
      	$em = $this->getDoctrine()->getManager();
      	$em->persist($user);
      	$em->flush();
      	//send email
          $message = (new \Swift_Message('Hello Email'))
        ->setFrom('estebanalcoy@gmail.com')
        ->setTo('estebancano2005@hotmail.com')     
        ->addPart(
            $this->renderView(
                'Emails/registration.txt.twig',
                array('name' => $user)
            ),
            'text/plain'
        )
        
    ;

    

    // or, you can also fetch the mailer service this way
     $this->get('mailer')->send($message);


      }
      return $this->render('user/nuevo.html.twig',array("form"=>$form->createView()));
      //return $this->redirectToRoute('/user');
    }
}
