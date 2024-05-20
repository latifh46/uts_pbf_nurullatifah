<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelUsers extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['created_at', 'updated_at'];
}
