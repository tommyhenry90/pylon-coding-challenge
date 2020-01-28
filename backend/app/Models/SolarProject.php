<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolarProject extends Model
{
    protected $fillable = [
        'title',
        'system_size',
        'site_latitude',
        'site_longitude',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
}
