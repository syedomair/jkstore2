<?php

namespace JKStore\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JKStore\Repository\CategoryCollection;

class HomeController extends Controller {

    public function homeAction(){

        $conn = $this->get('database_connection'); 
	$catRepository = new CategoryCollection($conn);
        $categoriesCollection = $catRepository->findAll();

        $data = array(
            'groupCategories' => $categoriesCollection 
	);

    return $this->render('JKStoreBundle:Home:home.html.twig', $data); 
    }
}
