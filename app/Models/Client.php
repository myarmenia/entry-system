<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function person_position(): BelongsToMany{

        return $this->belongsToMany(PersonPosition::class);

    }
    public function entry_codes(): HasMany{

        return $this->hasMany(EntryCode::class);
    }
    public function people(): HasMany{

        return $this->hasMany(Person::class);
    }
    public function turnstiles(){

        return $this->hasMany(Turnstile::class);

    }



}
