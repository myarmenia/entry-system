<?php
namespace App\DTO;
use Illuminate\Support\Arr;

class UserDto
{
        public readonly string  $name;
        public readonly string $email;

        public  ?string $password;

        public readonly  array $roles;

    public function __construct(
            array $data

        )
    {
        $this->name=$data['name'];
        $this->email=$data['email'];
        $this->password=$data['password'] ?? null;
        $this->roles=$data['roles'];


    }
    public static function fromArray()
    {


        $user =new self(
            $this->name,
            email: $data['email'],

            roles:$data['roles'],
        );
        if (!empty($data['password'])) {
            $user->password=$data['password'];
        }
        return $user;

    }
    public function toArray(){
        // dd($this);
        $user= [
            "name"=>$this->name,
            "email"=>$this->email,
            // "password"=>$this->password ?? null,
            "roles"=>$this->roles,
        ];
        if($this->password!=null){
            $user['password']=$this->password;
        }
        return $user;
    }
}
