<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use AppBundle\Entity\Task;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class FirstPageController extends Controller
{
   
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $task = new Task();
        $task->setTask('urlHere');

       
        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class, array('label' => 'Put Link'))
            ->add('save', SubmitType::class, array('label' => 'crawl'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $info = $form["task"]->getData();
            //Executes in background my custom script
            $process = new Process("php Scrapper.php $info");
            $process->disableOutput();
            //function run() takes quite long so I left this
            $process->start();
   
            return $this->redirectToRoute('secondpage');
        }
        
        return $this->render('EmailCrawler/firstpage.html.twig',array('form' => $form->createView(),
        'title' => "EmailCrawler"
    ));
    }
   
    
}
