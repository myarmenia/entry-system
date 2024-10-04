<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function clients(): BelongsTo{

        return $this->belongsTo(Client::class,'client_id');
    }
    public function person_permissions(){
        return $this->hasMany(PersonPermission::class);
    }

    public function attendance_sheets(){
        return $this->hasMany(AttendanceSheet::class);
    }


}
