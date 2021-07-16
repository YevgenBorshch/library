<?php


namespace App\Http\Controllers\Api\Auth;


use App\Exceptions\ApiAuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Response;

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
     * @return Response
     * @throws ApiAuthException
     */
    public function __invoke(RegisterRequest $request): Response
    {
        $credentials = $request->validated();
        try {
            $user = $this->userRepository->store($credentials);

            return response([
                'user' => $user,
                'token' => $user->createToken('Token')->accessToken
            ], 201);

        } catch (Exception $e) {
            throw new ApiAuthException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('auth.exception.create'))
            );
        }
    }
}
