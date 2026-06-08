<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Memberikan izin pengisian data kolom termasuk image
    protected $fillable = [
        'title',
        'creator',
        'category',
        'description',
        'image',
    ];
}