<?php

namespace App\DTO;
use Illuminate\Http\Request;

class EntryExitSystemDto
{

    public function __construct(
        public readonly string $mac,
        public readonly string $entry_code,
        public  string $date_time,
        public readonly string $local_ip,
        public readonly string $type,
        public ?int $people_id = null

    ) {
    }

    public static function fromEntryExitSystemDto(Request $request): EntryExitSystemDto
    {
        return new self(
            mac: $request->mac,
            entry_code: $request->entry_code,
            date_time: $request->date_time,
            local_ip: $request->local_ip,
            type: $request->type
        );
    }

    public function toArray()
    {
        return [
            'date' => $this->date_time,
            'local_ip' => $this->local_ip,
            'type' => $this->type,
            'people_id' => $this->people_id
        ];
    }


}
