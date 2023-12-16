<?php

namespace App\Services;

use App\Models\FirebaseUser;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Contract\Storage as FirebaseStorage;
use Symfony\Component\HttpFoundation\Response;

class FirebaseService implements FirebaseServiceInterface
{
    const METHOD_FRESH_TOKEN = 'fresh_token';
    const METHOD_USERNAME_PASSWORD = 'username_password';

    /** @var FirebaseAuth */
    private $auth;
    private $storage;

    public function __construct(FirebaseAuth $firebase, FirebaseStorage $firebaseStorage)
    {
        $this->auth = $firebase;
        $this->storage = $firebaseStorage;
    }

    /**
     * login function
     *
     * @param string $method
     * @param array $params
     * @return array
     */
    public function login(string $method, array $params)
    {
        try {
            if ($method == self::METHOD_USERNAME_PASSWORD) {
                $signInResult = $this->auth->signInWithEmailAndPassword($params['email'], $params['password']);
                $signInResult = $this->auth->signInWithRefreshToken($signInResult->refreshToken());
            } else if ($method == self::METHOD_FRESH_TOKEN) {
                $signInResult = $this->auth->signInWithRefreshToken($params['refresh_token']);
            }

            $userInfo = $this->auth->getUser($signInResult->firebaseUserId())->jsonSerialize();
            $firebaseUser = FirebaseUser::updateOrCreate(
                [
                    'uid' => $userInfo['uid'],
                    'email' => $userInfo['email'],
                ],
                [
                    'display_name' => $userInfo['displayName'],
                    'local_id' => $userInfo['localId'] ?? null,
                    'phone_number' => $userInfo['phoneNumber'],
                    'photo_url' => $userInfo['photoUrl']
                ]
            );
            $data = array_merge($firebaseUser, $signInResult->asTokenResponse());
        } catch (\Throwable $th) {
            return [Response::HTTP_BAD_REQUEST, $th->getMessage()];
        }

        return [
            Response::HTTP_OK, $data
        ];
    }

    /**
     * register function
     *
     * @param array $params
     * @return array
     */
    public function register(array $params) {
        try {
            $result = $this->auth->createUser($params)->jsonSerialize();
            $params['uid'] = $result['uid'];

            $firebaseUser = FirebaseUser::create($params);
        } catch (\Throwable $th) {
            return [Response::HTTP_BAD_REQUEST, $th->getMessage()];
        }

        return [
            Response::HTTP_OK, $firebaseUser
        ];
    }

    /**
     * uploadFile function
     *
     * @param [type] $file
     * @return void
     */
    public function uploadFile($file) {
        $this->storage;
    }
}
