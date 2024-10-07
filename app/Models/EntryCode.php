<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EntryCode extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = "entry_codes";

    public function users(): BelongsTo{

        return $this->belongsTo(User::class,'user_id');
    }

    public function people(){
        return $this->belongsTo(Person::class,'people_id');
    }
    public function person_permissions(): HasOne{
        return $this->hasOne(PersonPermission::class);
    }

}
