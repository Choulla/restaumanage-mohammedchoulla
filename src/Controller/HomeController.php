<?php

namespace App\Controller;

use App\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/getfilepath")
     */
    public function test(ContainerBagInterface $containerBag){
        //get file content
        //$rot = $this->getParameter('kernel.project_dir')."/scripts";
        //past it in $str
        //$projectRoot = $containerBag->get('kernel.project_dir');
       // dd($projectRoot."/scripts/script.sql");
        //$projectDirAlt = $this->getParameter('kernel.project_dir');
        //dd($projectDirAlt);
        //return $containerBag->get('kernel.project_dir')."/scripts/script.sql";
        dd(
            file_get_contents(__DIR__."/../../scripts/script.sql")
        );
    }

    /**
     * @Route("/",name="home")
     */
    public function index(){
        return new Response(
            $this->renderView("home.html.twig")
        );
    }

}