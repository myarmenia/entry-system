<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
class UserService
{

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function createUser(array $data)
    {
        // Хешируем пароль перед сохранением
        $data['password'] = Hash::make($data['password']);

        // Вызываем метод репозитория для сохранения пользователя
        return $this->userRepository->store($data);
    }

    public function getUserByEmail(string $email)
    {
        // Используем репозиторий для поиска пользователя по email
        return $this->userRepository->findByEmail($email);
    }
}
