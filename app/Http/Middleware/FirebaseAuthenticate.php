<?php

namespace App\Http\Middleware;

use App\Models\FirebaseUser;
use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Symfony\Component\HttpFoundation\Response;

class FirebaseAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $accessToken = $request->bearerToken();
        if (!$accessToken) {
            return response()->json(
                [
                    'error' => 'Invalid credentials'
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        try {
            // check and get uid by access token
            $userId = $this->verifyAndGetUidManual($accessToken);
            if (!$userId) {
                $checkRevoked = true;
                $result = Firebase::auth()->verifyIdToken($accessToken, $checkRevoked)->claims()->all();
                $userId = $result['user_id'];
            }

            $firebaseUser = FirebaseUser::where('uid', $userId)->first();
            if (!$firebaseUser) {
                return response()->json(
                    [
                        'error' => 'Invalid credentials'
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $request->setUserResolver(function () use ($firebaseUser) {
                return $firebaseUser;
            });
        } catch (FailedToVerifyToken $e) {
            return response()->json(
                [
                    'error' => $e->getMessage()
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        return $next($request);
    }

    /**
     * verifyAndGetUidManual function
     *
     * @param string $accessToken
     * @return mixed
     */
    private function verifyAndGetUidManual($accessToken) {
        $parseToken = Firebase::auth()->parseToken($accessToken);

        $tokenInfo = $parseToken->claims();
        $iat = $tokenInfo->get('iat');
        $exp = $tokenInfo->get('exp');
        $userId = $tokenInfo->get('user_id');
        if (now()->getTimestamp() > $exp->getTimestamp()) {
            return null;
        }

        // check if token created > 10 minutes ago -> check by SDK
        if ((now()->getTimestamp() - $iat->getTimestamp()) > 600) {
            return null;
        }

        return $userId;
    }
}
