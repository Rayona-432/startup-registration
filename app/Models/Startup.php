<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Startup extends Model
{
    use HasFactory;

    protected $fillable = [
        'startup_name',
        'founder_name',
        'email',
        'phone',
        'website',
        'sector',
        'deck',
    ];
}
