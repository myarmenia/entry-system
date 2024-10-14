<?php

namespace App\Services;


use App\Interfaces\AttendanceSheetInterface;
use App\Interfaces\CheckEntryCodeInterface;
use App\Interfaces\ClientIdFromTurnstileInterface;
use Illuminate\Http\Request;

class EntryExitSystemService
{
    public function __construct(
        protected ClientIdFromTurnstileInterface $turnstileRepository,
        protected CheckEntryCodeInterface $checkEntryCodeRepository,
        protected AttendanceSheetInterface $attendanceSheetRepository


    ) {
    }

    public function ees($data)
    {

        $result = null;
        $message = 'entry_coed is valid';

        $client_id = $this->turnstileRepository->getClientId($data->mac);

        if(!$client_id){
            $message = 'invalid mac';
        }
        else{

            $checkEntryCode = $this->checkEntryCodeRepository->checkEntryCode($data->entry_code, $client_id);

            if (!$checkEntryCode->result) {
                $message = $checkEntryCode->message;
            } else {
                $data->date_time = date('Y-m-d H:i:s', $data->date_time);

                $person_permission = $checkEntryCode->result->person_permission;
                $peopleId = $person_permission ? $person_permission->people_id : null;
                $data->people_id = $peopleId;

                $result = $this->attendanceSheetRepository->create($data->toArray());
            }
        }


        return (object) [
            'message' => $message,
            'result' => $result
        ];

    }

}
