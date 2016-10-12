<?php
namespace Domain\Manager;

use Domain\Repository\RepositoryInterface;

interface ManagerInterface
{
    public function getRepository();
    public function setRepository(RepositoryInterface $repositorio);
    public function save($entidad);
    public function remove($entidad);
    public function get($idEntidad);
    public function create($data);
    public function update($data, $id);
    public function getAll($offset, $limit);
}