<?php


namespace App\Repositories\Eloquent;


use App\Exceptions\ApiArgumentException;
use App\Traits\CheckEnvironment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @param array $value
     * @return Model
     */
    public function store(array $value): Model
    {
        return $this->model::create($value);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws ApiArgumentException
     */
    public function list(Request $request)
    {
        $currentPage = $request->get('currentPage', 1);
        $perPage = $request->get('perPage', 10);
        $orderBy = $request->get('orderBy', 'desc');

        if (!$perPage || $perPage < 1 || !$this->model::validateOrder($orderBy)) {
            throw new ApiArgumentException(
                $this->filterErrorMessage(__CLASS__, __LINE__, $request->getContent())
            );
        }

        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        return $this->model::orderBy('id', $orderBy)->paginate($perPage);
    }

    /**
     * @param array $value
     * @return bool
     * @throws ApiArgumentException
     */
    public function update(array $value): bool
    {
        $existValue = $this->model::find($value['id']);

        if (!$existValue) {
            throw new ApiArgumentException(
                $this->filterErrorMessage(__CLASS__, __LINE__, json_encode($value))
            );
        }

        return $existValue->update($value);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function remove(int $id): bool
    {
        return $this->model::find($id)->delete();
    }
}
