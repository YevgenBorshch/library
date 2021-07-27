<?php


namespace App\Repositories\Eloquent;


use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(User::class);
    }

    /**
     * @param array $credentials
     * @return User
     */
    public function store(array $credentials): User
    {
        return User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password'])
        ]);
    }

    /**
     * @param string $column
     * @param string $values
     * @return mixed
     */
    public function getUserByColumn(string $column, string $values)
    {
        return $this->model::where($column, $values)->first();
    }
}
