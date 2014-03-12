<?php

namespace JKStore\Repository;

use Doctrine\DBAL\Connection;
use JKStore\EntityDB\Category;

class CategoryCollection implements CollectionInterface {
    protected $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function save($category) {
        $categoryData = array(
            'name' => $category->getName(),
        );

        if ($category->getCategory_Id()) {
            $this->db->update('Category', $categoryData, array('category_id' => $category->getCategory_Id()));
        }
        else {
            $this->db->insert('Category', $categoryData);
            // Geting newly created category and set it on the entityDB.
            $id = $this->db->lastInsertId();
            $category->setCategory_Id($id);

        }
    }

    public function delete($category) {
        return $this->db->delete('Category', array('category_id' => $category->getCategory_Id()));
    }

    public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(category_id) FROM Category');
    }

    public function find($id) {
        $categoryData = $this->db->fetchAssoc('SELECT * FROM Category WHERE category_id = ?', array($id));
        return $categoryData ? $this->buildCategory($categoryData) : FALSE;
    }

    public function findAll() {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('a.*')
            ->from('Category', 'a');
        $statement = $queryBuilder->execute();
        $categoriesData = $statement->fetchAll();

        $categories = array();
        foreach ($categoriesData as $categoryData) {
            $categoryId = $categoryData['category_id'];
            $categories[$categoryId] = $this->buildCategory($categoryData);
        }
        return $categories;
    }

    protected function buildCategory($categoryData) {
        $category = new Category();
        $category->setCategory_Id($categoryData['category_id']);
        $category->setName($categoryData['name']);
        return $category;
    }
}
