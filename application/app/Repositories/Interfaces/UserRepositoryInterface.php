<?php


namespace App\Repositories\Interfaces;


use App\Models\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param array $credentials
     * @return User
     */
    public function store(array $credentials): User;

    /**
     * @param string $column
     * @param string $values
     * @return mixed
     */
    public function getUserByColumn(string $column, string $values);
}
