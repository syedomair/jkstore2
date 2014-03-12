<?php

namespace JKStore\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JKStore\Repository\CategoryCollection;
use JKStore\Repository\ProductCollection;

class ProductListController extends Controller {

    public function productListAction($catId){

          $conn = $this->get('database_connection');
          $catRepository = new CategoryCollection($conn);
          $prodRepository = new ProductCollection($conn);
          
	  $categoriesCollection = $catRepository->findAll();
	  $productListCollection = $prodRepository->findCat($catId);
          $data = array(
              'groupProductList'=> $productListCollection,
              'groupCategories' => $categoriesCollection
          );

     return $this->render('JKStoreBundle:ProdList:prodlist.html.twig', $data);
    }
}
