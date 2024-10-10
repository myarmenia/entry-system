<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $table = 'people';

    public function client(): BelongsTo{

        return $this->belongsTo(Client::class,'client_id');
    }
    public function person_permission(): HasOne{
        return $this->hasOne(PersonPermission::class);
    }

    public function attendance_sheets(): HasMany
    {
        return $this->hasMany(AttendanceSheet::class);
    }



}