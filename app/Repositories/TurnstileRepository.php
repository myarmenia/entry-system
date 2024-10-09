<?php

namespace App\Repositories;
use App\Interfaces\CheckEntryCodeInterface;
use App\Interfaces\ClientIdFromTurnstileInterface;
use App\Interfaces\FindEntryCodeInterface;
use App\Models\EntryCode;
use App\Models\Turnstile;


class TurnstileRepository implements ClientIdFromTurnstileInterface, CheckEntryCodeInterface
{

    public function getId($mac):mixed
    {
        $turnstile = Turnstile::where('mac', $mac)->first();
        return $turnstile != null ? $turnstile->user_id : false;
    }

    public function checkEntryCode($entry_code):bool
    {
        $entry_code = EntryCode::where('token', $entry_code)->first();
        return $entry_code != null ? true : false;
    }
}
