<?php

namespace App\Repositories;
use App\Interfaces\CreateEntryCodeInterface;
use App\Interfaces\FindEntryCodeInterface;
use App\Models\EntryCode;


class EntryCodeRepository implements CreateEntryCodeInterface, FindEntryCodeInterface
{

    public function create(array $data)
    {
        return EntryCode::create($data);
    }

    public function find($token)
    {
        return EntryCode::where('token', $token);
    }


}
