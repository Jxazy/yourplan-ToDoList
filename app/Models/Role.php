<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    /**
     * Get all of the users for the Role
     *

     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
