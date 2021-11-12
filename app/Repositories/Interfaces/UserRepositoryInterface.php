<?php


namespace App\Repositories\Interfaces;


use App\Models\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param string $column
     * @param string $values
     * @return mixed
     */
    public function getUserByColumn(string $column, string $values);
}
