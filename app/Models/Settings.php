<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'name',
        'email',
        'logo_url',
        'meta_description',
        'google_ads_client',
        'google_ads_slot',
        'tracking_id',
        'social_bandcamp',
        'social_email',
        'social_facebook',
        'social_houzz',
        'social_instagram',
        'social_linkedin',
        'social_phone',
        'social_pinterest',
        'social_twitter',
        'social_youtube',
    ];
}
