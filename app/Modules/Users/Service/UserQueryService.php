<?php

namespace App\Modules\Users\Service;

use App\Models\User;
use App\Modules\Users\repository\UserRepository;
use App\Modules\Users\Validations\UserValidationByEmail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserQueryService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function validateUserCredentials(Request $request)
    {
        $user = User::query()->where('email', $request->input('username'))->first();
        if ($user &&
            Hash::check($request->input('password'), $user->password) &&
            $user->type_user == $request->input('type_user')
        ) {
            return true;
        }
        return false;
    }
    public function findById($id)
    {
        if (!$id) throw new ModelNotFoundException('User ID is missing.');

        $user = $this->userRepository->findById($id);
        if ($user) return response()->json($user);

        return response()->json(['error' => 'User not found.'], JsonResponse::HTTP_NOT_FOUND);
    }

    public function getAll()
    {
        $perPage = request()->input('per_page', 10);
        $page = request()->input('page', 1);

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $users = $this->userRepository->all($perPage);

        return response()->json($users);
    }

    public function updateUser($id)
    {
//        $this->userRepository->update('','');
    }
}
