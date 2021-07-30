<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiArgumentException;
use App\Http\Requests\Category_Series_Tag\UpdateRequest;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Traits\CheckEnvironment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, CheckEnvironment;

    /**
     * Это общий метод для сущностей Category, Series, Tag - потому что они идентичны
     * @param Request $request
     * @param BaseRepositoryInterface $repository
     * @return JsonResponse
     * @throws ApiArgumentException
     * @throws ValidationException
     */
    public function update(Request $request, BaseRepositoryInterface $repository): JsonResponse
    {
        $value = Validator::make(
            json_decode($request->getContent(), true),
            (new UpdateRequest())->rules()
        );

        if ($value->fails()) {
            throw new ApiArgumentException(
                $this->filterErrorMessage(__CLASS__, __LINE__, $request->getContent())
            );
        }

        return response()->json([
            'result' => $repository->update($value->validated())
        ], 202);
    }
}
