<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded =[];
    protected $table = 'people';

    public function client(): BelongsTo{

        return $this->belongsTo(Client::class,'client_id');
    }
    public function person_permission(): HasMany
    {
        return $this->hasMany(PersonPermission::class);
    }

    public function attendance_sheets(): HasMany
    {
        return $this->hasMany(AttendanceSheet::class);
    }
    public function activated_code_connected_person(): HasOne{
        return $this->hasOne(PersonPermission::class)->where('status',1);
    }




}
