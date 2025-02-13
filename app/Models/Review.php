<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'id', 'name', 'review', 'approved',
    ];

    // Get all approved reviews.
    public static function getApproved()
    {
        return Review::where('approved', true)->orderBy('created_at', 'desc')->get();
    }
}
