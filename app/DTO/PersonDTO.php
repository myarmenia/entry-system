<?php
namespace App\DTO;

class PersonDTO
{
    public $id;
    public $entry_code_id;
    public $client_id;
    public $name;
    public $surname;
    public $email;
    public $phone;
    public $type;
    public $image;
    public function __construct($id, $entry_code_id, $client_id, $name, $surname, $email, $phone, $type, $image)
    {
        $this->id = $id;
        $this->entry_code_id = $entry_code_id;
        $this->client_id = $client_id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->phone = $phone;
        $this->type = $type;
        $this->image = $image;
    }

    public static function fromModel($person)
    {

        return new self(
        $person->id,
        $person->entry_code_id,
 $person->client_id,
      $person->name,
   $person->surname,
     $person->email,
     $person->phone,
      $person->type,
     $person->image,
        );
    }

}
