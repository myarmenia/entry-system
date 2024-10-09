<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonPermission extends Model
{
    use HasFactory;

    protected $guarded =[];
    public function people(): BelongsTo{

        return $this->belongsTo(Person::class,'people_id');
    }

    public function entry_code(): BelongsTo{

        return $this->belongsTo(EntryCode::class,'entry_code_id');
    }



}
