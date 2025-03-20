<?php

namespace App\Models;

use App\Helpers\MyHelper;
use App\Traits\ReportFilterTrait;
use App\Traits\ReportTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceSheet extends Model
{
    use HasFactory,ReportFilterTrait;

    protected $guarded =[];
    protected $table = 'attendance_sheets';
    protected $filterFields = ['people_id','date'];
    protected $filterFieldsInRelation = ['name'];

    public function people(): BelongsTo{

        return $this->belongsTo(Person::class,'people_id');
    }

    public function scopeForClient(Builder $query, $month)
    {

        $clientId = MyHelper::find_auth_user_client();

         [$year, $month] = explode('-', $month);

            $monthDate = Carbon::createFromDate($year, $month, 1);

            $startOfMonth =  $monthDate->startOfMonth()->toDateTimeString();
            $endOfMonth =  $monthDate->endOfMonth()->toDateTimeString();

        return $query->whereHas('people', function ($q) use($clientId) {
            $q->where('client_id', $clientId);
        })
        ->whereYear('date', $year)
        ->whereMonth('date', $month);
        ;
        // ->whereYear('date', $year)
        // ->whereMonth('date', $month);
    }






}
