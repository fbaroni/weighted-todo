<?php

namespace Domain\Repository;

interface RepositoryInterface
{
    public function find($id);
    public function findAll();
    public function findBy(array $criteria, array $order = null, $limit = null, $offset = null);
    public function findOneBy(array $criteria, array $order = null, $limit = null, $offset = null);
    public function save($object);
    public function remove($object);
    public function begin();
    public function commit();
}
