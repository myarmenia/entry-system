<?php

namespace App\DTO;
use Illuminate\Http\Request;

class CheckEntryCodeDto
{

    public function __construct(
        public readonly string $mac,
        public readonly string $entry_code,
        public readonly string $date_time,
        public readonly string $local_ip,
        public readonly string $type


    ) {
    }

    public static function fromCheckEntryCode(Request $request): CheckEntryCodeDto
    {
        return new self(
            mac: $request->mac,
            entry_code: $request->entry_code,
            date_time: $request->date_time,
            local_ip: $request->local_ip,
            type: $request->type
        );
    }

    
}
