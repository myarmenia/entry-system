<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // public function role()
    // {
    //     return $this->belongsTo(Role::class);
    // }


    public function entry_codes(){

        return $this->hasMany(EntryCode::class);
    }
    public function people(){

        return $this->hasMany(Person::class);
    }
    public function turnstiles(){

        return $this->hasMany(Turnstile::class);

    }
    public function staff(){

        return $this->hasMany(Staff::class);

    }
    public function client(){
        return $this->hasOne(Client::class);
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
          
            $user->client()->delete();

        });
    }

}
