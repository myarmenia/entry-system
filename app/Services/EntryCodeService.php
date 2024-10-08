<?php

namespace App\Services;

use App\DTO\EntryCodeTdo;
use App\Models\EntryCode;
use App\Models\Turnstile;
use Illuminate\Http\Request;

class EntryCodeService
{


    public function store(EntryCodeTdo $dto)
    {
 
        $client_id = Turnstile::where('mac',$dto->mac)->first()->user_id;
   
        return EntryCode::create([
            'user_id' => $client_id,
            'type' => $dto->type,
            'token' => $dto->token,
        ]);
    }


}
