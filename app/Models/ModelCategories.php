<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCategories extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'categories';
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];
}
