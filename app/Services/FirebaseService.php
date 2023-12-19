<?php

namespace App\Services;

use App\Http\Resources\FirebaseUserResource;
use App\Models\FirebaseUser;
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
                $signInResult = $this->auth->signInWithEmailAndPassword($params['email'], $params['password'])->asTokenResponse();
                $signInResult['access_token'] = $signInResult['id_token'];
            } else if ($method == self::METHOD_FRESH_TOKEN) {
                $signInResult = $this->auth->signInWithRefreshToken($params['refresh_token'])->asTokenResponse();
            }

            $userInfo = $this->auth->getUser(
                $this->auth->parseToken($signInResult['access_token'])->claims()->get('user_id')
            )->jsonSerialize();

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

            $data = array_merge((new FirebaseUserResource($firebaseUser))->toArray(), $signInResult);
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
    public function register(array $params)
    {
        try {
            // change format phoneNumber to store firebase
            $params['phoneNumber'] = '+84' . ltrim($params['phoneNumber'], '0');
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
     * logout function
     *
     * @param string $uid
     * @return array
     */
    public function logout(string $uid)
    {
        try {
            $this->auth->revokeRefreshTokens($uid);
            return [
                Response::HTTP_OK, []
            ];
        } catch (\Throwable $th) {
            return [Response::HTTP_BAD_REQUEST, $th->getMessage()];
        }
    }

    /**
     * uploadFile function
     *
     * @param [type] $file
     * @return void
     */
    public function uploadFile($file)
    {
        $this->storage;
    }
}
