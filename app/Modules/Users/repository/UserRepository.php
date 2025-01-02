<?php

namespace App\Modules\Users\repository;

use App\Models\User;
use Illuminate\Http\Request;

class UserRepository
{
    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($perPage = 10)
    {
        return User::paginate($perPage);
    }

    /**
     * Get a user by ID.
     *
     * @param int $id
     * @return \App\Models\User|null
     */
    public function findById($id)
    {
        return User::find($id);
    }

    public function findByEmail($email)
    {
        $user = User::query()->where('email', $email)->first();
        return $user?->toArray();
    }

    public function create(array $data)
    {
        return User::query()->create($data);
    }

    public function update($id, Request $request)
    {
        $user = $this->findById($id);
        if ($user) {
            if($request->file('image')) {
                if ($user->hasMedia(User::MEDIA_COLLECTION)) {
                    $user->clearMediaCollection(User::MEDIA_COLLECTION);
                }
                $user->addMedia($request->file('image'))
                    ->toMediaCollection(User::MEDIA_COLLECTION);
            }
             $user->update($request->all());
            return response()
                ->json([
                    'msg' => 'The user has been updated!',
                    'data'=>$user
                ], 201);
        }

        return response()
            ->json(['error' => 'The user is not found in our database!'], 400);
    }


    public function delete($id)
    {
        $user = $this->findById($id);

        if ($user && $user->delete()) {
            return [];
        }
        return response()
                ->json(['error' => 'The user is not found in our database!'], 400);

    }
}
