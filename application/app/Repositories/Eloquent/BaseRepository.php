<?php


namespace App\Repositories\Eloquent;


use App\Traits\CheckEnvironment;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /**
     * Trait filter error message for prod environment
     */
    use CheckEnvironment;
    
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param string $model
     */
    public function __construct(string $model)
    {
        $this->model = $model;
    }
}
