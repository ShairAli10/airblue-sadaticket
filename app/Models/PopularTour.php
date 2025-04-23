<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopularTour extends Model
{
    use HasFactory;

    protected $table = 'popular_tours';
    protected $gurarded = 'id';
}
