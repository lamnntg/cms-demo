<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\ApiController;
use App\Models\FirebaseUser;
use App\Services\FirebaseService;
use App\Services\FirebaseServiceInterface;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\Auth\InvalidCustomToken;
use Lcobucci\JWT\Token\Parser;

class AuthController extends ApiController
{
    /** @var FirebaseServiceInterface */
    private $firebaseService;

    public function __construct(FirebaseServiceInterface $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'nullable|max:255',
            'password' => 'required|min:6',
            'email' => 'required|email',
            'displayName' => 'nullable|string',
            'phoneNumber' => 'nullable|string',
            'photoUrl' => 'nullable|url',
        ]);

        [$status, $data] = $this->firebaseService->register($request->all());

        return $this->response($data, $status);
    }

    /**
     * login function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'refresh_token' => 'nullable|string',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        [$status, $data] = $this->firebaseService->login(FirebaseService::METHOD_USERNAME_PASSWORD, $request->all());

        return $this->response($data, $status);
    }
}
