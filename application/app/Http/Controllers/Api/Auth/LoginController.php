<?php


namespace App\Http\Controllers\Api\Auth;


use App\Exceptions\ApiAuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * LoginController constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param LoginRequest $request
     * @return Response
     * @throws ApiAuthException
     */
    public function __invoke(LoginRequest $request): Response
    {
        $credentials = $request->validated();
        $user = $this->userRepository->getUserByColumn('email', $credentials['email']);

        if(!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new ApiAuthException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('auth.exception.find'))
            );
        }

        return response([
            'user' => $user,
            'token' => $user->createToken('Token')->accessToken
        ], 201);
    }
}