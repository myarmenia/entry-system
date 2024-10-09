<?php

namespace App\Services;


use App\DTO\EntryCodeDto;
use App\Interfaces\ClientIdFromTurnstileInterface;
use App\Interfaces\CreateEntryCodeInterfase;
use App\Interfaces\FindEntryCodeInterfase;
use App\Models\EntryCode;
use App\Models\Turnstile;
use App\Repositories\TurnstileRepository;
use Illuminate\Http\Request;

class CheckEntryCodeService
{
    public function __construct(
        protected ClientIdFromTurnstileInterface $turnstileRepository

    ) {
    }

    public function check($data)
    {

        // dd($data->mac);
        // if(!$this->turnstileRepository->getId($data->mac)){
        //     return ['message' => 'invalid mac'];
        // }

        $entry_code = $this->turnstileRepository->checkEntryCode($data->entry_code);
        
        if(!$entry_code){
            return ['message' => 'entry_coed not found'];
        }
        dd($entry_code);
        // return $this->checkQR($data['qr'][0], $data['mac'], $online);0

    }


    // public function find($token)
    // {
    //     return $this->findEntryCodeRepository->find($token);
    // }

}
