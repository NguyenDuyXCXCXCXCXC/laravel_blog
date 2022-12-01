<?php

namespace App\Repositories;

use App\Models\User;

class UserRepositories
{

    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getListAdminManagerByParams($searchRequest, $selected_option): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $searchMailName = $searchRequest[0];
        $searchSex = $searchRequest[1];
        $query = $this->user->query()->Where(function($query)  {
                $query->orwhere('role', '=', 1)
                    ->orwhere('role', '=', 3);
            });

        if(!empty($searchMailName)){
            $query = $query->Where(function($query) use ($searchMailName) {
                    $query->orwhere('last_name', 'LIKE', "%{$searchMailName}%")
                        ->orwhere('first_name', 'LIKE', "%{$searchMailName}%")
                        ->orwhere('email', 'LIKE', "%{$searchMailName}%");
                });
        }

        if(!empty($searchSex)){
            $query = $query->where('sex', '=', "{$searchSex}");
        }

        $users = $query->orderByDesc('id')->paginate($selected_option);

        return $users;
    }

    public function getListUser($searchMailName, $searchSex, $selected_option)
    {
        $query = $this->user->query()->where('role', '=', 2);

        if(!empty($searchMailName)){
            $query = $query->Where(function($query) use ($searchMailName) {
                $query->orwhere('last_name', 'LIKE', "%{$searchMailName}%")
                    ->orwhere('first_name', 'LIKE', "%{$searchMailName}%")
                    ->orwhere('email', 'LIKE', "%{$searchMailName}%");
            });
        }

        if(!empty($searchSex)){
            $query = $query->where('sex', '=', "{$searchSex}");
        }

        $users = $query->orderByDesc('id')->paginate($selected_option);

        return $users;
    }

    public function create($input)
    {
        return $this->user->create($input);
    }


    public function getUserById($id)
    {
        return $this->user->where('id', $id)->first();
    }


    public function getUserByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }

    public function updateInfor($userEdit, $input)
    {
        return $userEdit->update($input);
    }

    public function updatePassword($input, $userEdit)
    {
        return $userEdit->update(['password' => $input['password']]);
    }


    public function destroy($id)
    {
        return $this->user->find($id)->delete();
    }

}
