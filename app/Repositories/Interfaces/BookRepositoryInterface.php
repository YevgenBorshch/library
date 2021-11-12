<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Request;

interface BookRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param array $value
     * @return Model
     */
    public function store(array $value): Model;
}
