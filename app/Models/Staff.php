<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded =[];
    public function client(): BelongsTo{

        return $this->belongsTo(Client::class,foreignKey: 'client_admin_id');
    }
    public function user(): BelongsTo{

        return $this->belongsTo(User::class,foreignKey: 'user_id');
    }
}


