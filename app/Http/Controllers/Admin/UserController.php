<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FirebaseUser;
use App\Services\FirebaseServiceInterface;

class UserController extends Controller
{
    /** @var FirebaseServiceInterface */
    private $firebaseService;

    public function __construct(FirebaseServiceInterface $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function index() {
        $users = $this->firebaseService->getUsers();

        return view('user', compact('users'));;
    }
}
