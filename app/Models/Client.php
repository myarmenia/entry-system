<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $guarded =[];
    public function user(): BelongsTo{

        return $this->belongsTo(User::class,'user_id');
    }
    public function staff(): HasMany{

        return $this->hasMany(Staff::class);
    }
    public function person_position(): BelongsToMany{

        return $this->belongsToMany(PersonPosition::class);

    }





}
