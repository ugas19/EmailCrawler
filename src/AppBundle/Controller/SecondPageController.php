<?php 

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Entity\Emails;

class SecondPageController extends Controller
{
   
   /**
     * @Route("/secondpag", name = "secondpage")
     */
    public function iahowxAction(Request $request)
    {

        $product = $this->getDoctrine()
        ->getRepository(Emails::class)
        ->findAll();

    if (!$product) {
        throw $this->createNotFoundException(
            'No product found for id '.$productId
        );
    }
        $form = $this->createFormBuilder()
            ->add('save', SubmitType::class, array('label' => 'refresh'))
            ->add('back', SubmitType::class, array('label' => 'back'))
            ->getForm();
            $form->handleRequest($request);
            if ($form["back"]->isSubmitted() && $form->isValid()) {
            
                if($form->get('back')->isClicked() === true){
                    return $this->redirectToRoute('homepage');
                }
                if($form->get('save')->isClicked() === true){
                    return $this->redirectToRoute('secondpage');
                }
                
            }
            
        
        return $this->render('EmailCrawler/secondpage.html.twig',array('form' => $form->createView(),
        'title' => "EmailCrawler",'results' => $product
    ));
    }
    
}