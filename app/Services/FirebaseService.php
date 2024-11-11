<?php

namespace App\Services;

use App\Firebase\Firebase;
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
            $data = array_merge($userInfo, $signInResult->asTokenResponse());
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
            Response::HTTP_OK, $result
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

    /**
     * getUsers function
     * for admin users
     *
     * @return mixed
     */
    public function getUsers() {
        $localUsers = FirebaseUser::all()->pluck('uid');
        if ($localUsers->isEmpty()) {
            return [];
        }

        $firebaseUsers = $this->auth->getUsers($localUsers->toArray());
        $users = [];
        $inactiveUsers = [];
        foreach ($firebaseUsers as $uid => $user) {
            if (!$user) {
                $inactiveUsers[] = $uid;
                continue;
            }

            $user = $user->jsonSerialize();
            $user['metadata'] = $user['metadata']->jsonSerialize();
            $users[] = $user;
        }

        if (!empty($inactiveUsers)) {
            FirebaseUser::where('uid', $inactiveUsers)->delete();
        }

        return $users;
    }
}
