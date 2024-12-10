<?php

namespace App\Models;

use App\Traits\ReportFilterTrait;
use App\Traits\ReportTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceSheet extends Model
{
    use HasFactory;

    protected $guarded =[];
    protected $table = 'attendance_sheets';
    protected $filterFields = ['date'];

    public function people(): BelongsTo{

        return $this->belongsTo(Person::class,'people_id');
    }


}
