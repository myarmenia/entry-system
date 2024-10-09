<?php

namespace App\Http\Controllers\Api\Turnstile;

use App\DTO\CheckEntryCodeDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CheckEntryCodeRequest;
use App\Http\Requests\Api\CheckQRRequest;
use App\Services\CheckEntryCodeService;
use Illuminate\Http\Request;

class CheckEntryCodeController extends Controller
{
    public function __construct(protected CheckEntryCodeService $service)
    {

    }
    public function __invoke(CheckEntryCodeRequest $request){

        $data = $this->service->check(
            CheckEntryCodeDto::fromCheckEntryCode($request)
        );
    }
}
