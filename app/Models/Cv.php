<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'name', 'photo', 'role', 'bio', 'education', 'skills', 'experience', 'certifications'
    ];

    // Mengubah data JSON dari database menjadi Array di PHP
    protected $casts = [
        'skills' => 'array',
        'experience' => 'array',
        'certifications' => 'array',
    ];
}
