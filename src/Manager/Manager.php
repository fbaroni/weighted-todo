<?php
namespace Domain\Manager;

use Domain\Repository\RepositoryInterface;

abstract class Manager implements ManagerInterface
{
    protected $repository;
    protected $serializer;

    public function create($data)
    {
        // TODO: Implement create() method.
    }

    public function update($data, $id)
    {
        // TODO: Implement update() method.
    }

    public function setRepository(RepositoryInterface $repositorio)
    {
        $this->repository = $repositorio;
    }

    public function save($entidad)
    {
        $this->getRepository()->begin();
        $this->getRepository()->save($entidad);
        $this->getRepository()->commit();
    }

    public function remove($entidad)
    {
        $this->getRepository()->begin();
        $this->getRepository()->remove($entidad);
        $this->getRepository()->commit();
    }

    public function get($idEntidad)
    {
        return $this->getRepository()->find($idEntidad);
    }

    public function getAll($offset, $limit)
    {
        return $this->getRepository()->findBy([], null, $limit, $offset);
    }

    /**
     * @return RepositoryInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }

    public function getByName($name)
    {
        return $this->getRepository()->findOneBy(
            [
                'name' => $name
            ]
        );
    }
}