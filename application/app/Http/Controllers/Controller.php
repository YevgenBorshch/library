<?php

namespace App\Http\Controllers;

use App\DTO\ListDTO;
use App\Exceptions\ApiArgumentException;
use App\Http\Requests\Category_Series_Tag\RemoveRequest;
use App\Http\Requests\Category_Series_Tag\StoreRequest;
use App\Http\Requests\Category_Series_Tag\UpdateRequest;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Traits\CheckEnvironment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Shared methods for Category, Series, Tag.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, CheckEnvironment;

    /**
     * @param Request $request
     * @param BaseRepositoryInterface $repository
     * @return JsonResponse
     */
    public function list(Request $request, BaseRepositoryInterface $repository): JsonResponse
    {
        $value = $repository->list($request);

        $result = new ListDTO(
            $value->currentPage(),
            $value->perPage(),
            $value->total(),
            $value->lastPage(),
            $request->get('orderBy', 'desc'),
            $value->items(),
        );

        return response()->json(['data' => $result]);
    }

    /**
     * @param Request $request
     * @param BaseRepositoryInterface $repository
     * @return JsonResponse
     * @throws ApiArgumentException
     * @throws ValidationException
     */
    public function remove(Request $request, BaseRepositoryInterface $repository): JsonResponse
    {
        $value = $this->validation($request, new RemoveRequest());

        return response()->json([
            'result' => $repository->remove($value['id'])
        ], 202);
    }

    /**
     * @throws ApiArgumentException
     * @throws ValidationException
     */
    public function store(Request $request, BaseRepositoryInterface $repository): JsonResponse
    {
        $value = $this->validation($request, new StoreRequest());

        return response()->json([
            'result' => $repository->store($value)
        ], 202);
    }

    /**
     * @param Request $request
     * @param BaseRepositoryInterface $repository
     * @return JsonResponse
     * @throws ApiArgumentException
     * @throws ValidationException
     */
    public function update(Request $request, BaseRepositoryInterface $repository): JsonResponse
    {
        $value = $this->validation($request, new UpdateRequest());

        return response()->json([
            'result' => $repository->update($value)
        ], 202);
    }

    /**
     * @param Request $request
     * @param FormRequest $formRequest
     * @return array
     * @throws ApiArgumentException
     * @throws ValidationException
     */
    protected function validation(Request $request, FormRequest $formRequest): array
    {
        $value = Validator::make(
            json_decode($request->getContent(), true),
            $formRequest->rules()
        );

        if ($value->fails()) {
            throw new ApiArgumentException(
                $this->filterErrorMessage(__CLASS__, __LINE__, $request->getContent())
            );
        }

        return $value->validated();
    }
}
