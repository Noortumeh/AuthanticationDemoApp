<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'user_id',
        'bio',
        'phone',
        'address',
        'birthdate',
        'image',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
