<?php

namespace App\DTO;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ScheduleDetailsDto
{
    public function __construct(
        public string $name,
        public string $week_day,
        public string $day_start_time,
        public string $day_end_time,
        public ?string $break_start_time,
        public ?string $break_end_time,
        public ?int $status = null, // Должно быть int, так как в БД integer

    )
    {}

    public static  function fromRequestDto(Request $request): ScheduleNameDto {
        return  new self(
            name: $request->name,
            week_day: $request->week_day,
            day_start_time: $request->day_start_time,
            day_end_time:$request->day_end_time,
            break_start_time: $request->break_start_time,
            break_end_time: $request->break_end_time,
            status: $request->has('status') ? 1 : null // Если статус не пришёл, оставляем null

        );

    }

    public function toArray()
    {
        return array_filter([
            'name' => $this->name,
            'week_day'=>$this->week_day,
            'day_start_time'=>$this->day_start_time,
            'day_end_time'=>$this->day_end_time,
            'break_start_time'=>$this->break_start_time,
            'break_end_time'=>$this->break_end_time,
            'status' => $this->status,
        ], fn($value) => !is_null($value)); // Убираем null-значения
    }

}
