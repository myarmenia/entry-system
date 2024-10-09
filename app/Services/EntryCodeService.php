<?php

namespace App\Services;


use App\DTO\EntryCodeDto;
use App\Interfaces\ClientIdFromTurnstileInterface;
use App\Interfaces\CreateEntryCodeInterface;
use App\Interfaces\FindEntryCodeInterface;
use App\Models\EntryCode;
use App\Models\Turnstile;
use App\Repositories\EntryCodeRepository;
use Illuminate\Http\Request;

class EntryCodeService
{

    public function __construct(
        protected CreateEntryCodeInterface $createEntryCodeInterface,
        protected ClientIdFromTurnstileInterface $clientIdFromTurnstileInterface

    ) {
    }


    public function store(EntryCodeDto $dto)
    {

        $client_id = $this->clientIdFromTurnstileInterface->getId($dto->mac);

        $dto->user_id = $client_id;

        return $this->createEntryCodeInterface->create($dto->toArray());

    }



}
