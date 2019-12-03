<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    public function _menu()
    {
        $finder = new Finder();
        $finder->directories()->in("Entity");
        return $this->render('menu/_menu.html.twig', [
            "dossiers"=>$finder,

        ]);
    }
}