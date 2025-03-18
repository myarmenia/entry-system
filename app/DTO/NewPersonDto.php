<?php
namespace App\DTO;

class NewPersonDto
{

    public function __construct(
        public int $entry_code_id,
        public ?int $client_id =null,
        public string $name,
        public string $surname,
        public ?int  $schedule_name_id = null,
        public ?int  $department_id = null,
        public ?string $email = null,
        public ?string $phone =null,
        public string $type,
        public ?string $image = null,
    )
    {}

    public static  function fromRequestDto($request): NewPersonDto {
        return  new self(
            entry_code_id: $request->entry_code_id,
            name: $request->name,
            surname: $request->surname,
            schedule_name_id: $request->schedule_name_id,
            department_id: $request->department_id,
            email: $request->email,
            phone: $request->phone,
            type: $request->type,
            image: $request->image
        );

    }

}
