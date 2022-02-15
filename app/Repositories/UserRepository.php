<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements interfaces\IUserRepository
{
    /**
     * @var User
     */
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @inheritDoc
     */
    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @inheritDoc
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }
}
