<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi melalui mass assignment
    protected $fillable = [
        'name', 'code', 'contact_person', 'is_active',
    ];
}