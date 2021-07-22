<?php


namespace App\Http\Controllers\Api\Auth;


use App\Exceptions\ApiAuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;

class RegistrationController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * RegistrationController constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws ApiAuthException
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $user = $this->userRepository->store($credentials);

        if (!$user) {
            throw new ApiAuthException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('auth.exception.create'))
            );
        }

        return response()->json(['user' => $user], 201);
    }
}
