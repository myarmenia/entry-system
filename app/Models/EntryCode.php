<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    public function person_permission(): BelongsToMany{
        return $this->belongsToMany(PersonPermission::class);
    }

}
