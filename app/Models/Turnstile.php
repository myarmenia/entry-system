<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turnstile extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function clients(): BelongsTo{

        return $this->belongsTo(Client::class,foreignKey: 'client_id');
    }
}
