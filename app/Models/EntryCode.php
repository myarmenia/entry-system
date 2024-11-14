<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EntryCode extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = "entry_codes";

    public function client(): BelongsTo{

        return $this->belongsTo(Client::class,'client_id');
    }

    public function people(){
        return $this->belongsTo(Person::class,'people_id');
    }
    public function person_permission(): HasMany{
        return $this->hasMany(PersonPermission::class);
    }
    public function active_person(): HasOne{
        return $this->hasOne(PersonPermission::class)->where('status',1);
    }
    
     // now added
    public function person()
    {
        return $this->belongsToMany(Person::class, 'person_permissions', 'entry_code_id', 'person_id');
    }

}
