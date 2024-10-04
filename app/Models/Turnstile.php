<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turnstile extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function users(): BelongsTo{

        return $this->belongsTo(User::class,foreignKey: 'user_id');
    }
}
