<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function store(array $data): User
    {
        // dd($data['roles']);
        // Создаем пользователя с переданными данными
        // return User::create($data);
        $user = User::create($data);
        // $user->assignRole($request->input('roles'));
        $user->assignRole($data['roles']);
        $client=new Client();

        $client->user_id= $user->id;
        dd($data['client']);
        $client->name = $data['client']['name'];
        $client->email = $data['client']['email'];
        $client->address = $data['client']['address'];
        $client->save();
  dd($client);
        return $user;

    }

    public function findByEmail(string $email): ?User
    {
        // Поиск пользователя по email
        return User::where('email', $email)->first();
    }
}

