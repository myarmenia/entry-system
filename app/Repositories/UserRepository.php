<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\Staff;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Auth;

class UserRepository implements UserRepositoryInterface
{
    public function store(array $data): User
    {

        $user = User::create($data);

        $user->assignRole($data['roles']);



            if(isset($data['client']['name']) && $data['client']['name']!=null){
                $client=new Client();

                $client->user_id = $user->id;
                $client->name = $data['client']['name'];
                $client->email = $data['client']['email'];
                $client->address = $data['client']['address'];
                $client->save();




            }
            if (Auth::user()->hasRole('client_admin')){
                
                $client_admin_id = Client::where('user_id',Auth::id())->first()->id;

                $staff_user = [
                    'user_id' =>  $user->id,
                    'client_admin_id' => $client_admin_id
                  ];

                  Staff::create($staff_user);

            }




        return $user;

    }

    public function findByEmail(string $email): ?User
    {
        // Поиск пользователя по email
        return User::where('email', $email)->first();
    }
}
