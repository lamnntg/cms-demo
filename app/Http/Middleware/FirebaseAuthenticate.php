<?php

namespace App\Http\Middleware;

use App\Models\FirebaseUser;
use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Lcobucci\JWT\Token\Plain;
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
            $result = Firebase::auth()->verifyIdToken($accessToken)->claims()->all();
            $firebaseUser = FirebaseUser::where('uid', $result['user_id'])->first();
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
}
