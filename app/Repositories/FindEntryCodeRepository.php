<?php

namespace App\Repositories;
use App\Interfaces\FindEntryCodeInterface;
use App\Models\EntryCode;


class FindEntryCodeRepository implements FindEntryCodeInterface
{

    public function find($token)
    {
        return EntryCode::where('token', $token);
    }
}
