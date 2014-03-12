<?php

namespace JKStore\Repository;

/**
 * Collection interface.
 * Using Doctrine ORM.
 */
interface CollectionInterface {

    public function save($entity);

    public function delete($id);

    public function getCount();

    public function find($id);

    public function findAll();
}
