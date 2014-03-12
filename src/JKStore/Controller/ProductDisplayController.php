<?php

namespace JKStore\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JKStore\Repository\CategoryCollection;
use JKStore\Repository\ProductCollection;
 
class ProductDisplayController extends Controller {

    public function productDisplayAction($prodId){

 	$conn = $this->get('database_connection');
        $catRepository = new CategoryCollection($conn);
        $prodRepository = new ProductCollection($conn);

        $categoriesCollection = $catRepository->findAll();
        $product = $prodRepository->find($prodId);

        $data = array(
            'aProduct'=> $product,
            'groupCategories' => $categoriesCollection 
	);
     return $this->render('JKStoreBundle:ProdDisplay:product.html.twig', $data);
     }
}
