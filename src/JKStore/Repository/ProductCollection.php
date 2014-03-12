<?php

namespace JKStore\Repository;

use Doctrine\DBAL\Connection;
use JKStore\EntityDB\Product;

class ProductCollection implements CollectionInterface {
    protected $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

public function save($product) {
        $productData = array(
            'category_id' => $product->getCategory_id(),
            'name' => $product->getName(),
            'desc' => $product->getDesc(),
            'price' => $product->getPrice(),
            'img' => $product->getImg(),
        );

        if ($category->getProduct_Id()) {
            $this->db->update('Product', $productData, array('product_id' => $product->getProduct_Id()));
        }
        else {
            $this->db->insert('Product', $productData);
            // Geting newly created product and set it on the entityDB.
            $id = $this->db->lastInsertId();
            $product->setProduct_Id($id);

        }
    }

public function delete($product) {
        return $this->db->delete('Product', array('product_id' => $product->getProduct_Id()));
    }

public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(product_id) FROM Product');
    }

public function find($id) {
        $productData = $this->db->fetchAssoc('SELECT * FROM Product WHERE product_id = ?', array($id));
        return $productData ? $this->buildProduct($productData) : FALSE;
    }
    
public function findCat($pramCatId) {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('a.*')
            ->from('Product', 'a')
            ->where('a.category_id = :catId') 
	    ->setParameter('catId', $pramCatId);
	$statement = $queryBuilder->execute();
        $productListData = $statement->fetchAll();
        
	$productList = array();
        foreach ($productListData as $productData) {
            $productId = $productData['product_id'];
            $productList[$productId] = $this->buildProduct($productData);
        }
        return $productList;
    }

function findAll() {

        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('a.*')
            ->from('Product', 'a');
        $statement = $queryBuilder->execute();
        $productListData = $statement->fetchAll();

        $productList = array();
        foreach ($productListData as $productData) {
            $productId = $productData['product_id'];
            $productList[$productId] = $this->buildProduct($productData);
        }
        return $productList;
    }

protected function buildProduct($productData) {
        $product = new Product();
        $product->setProduct_Id($productData['product_id']);
        $product->setCategory_Id($productData['category_id']);
        $product->setName($productData['name']);
        $product->setDesc($productData['desc']);
        $product->setPrice($productData['price']);
        $product->setImg($productData['img']);
        return $product;
    }
}
