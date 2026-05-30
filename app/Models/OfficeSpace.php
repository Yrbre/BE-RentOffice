<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class OfficeSpace extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'thumbnail',
        'address',
        'is_open',
        'is_full_booked',
        'price',
        'duration',
        'about',
        'slug',
        'city_id',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'is_full_booked' => 'boolean',
    ];


    public function photos()
    {
        return $this->hasMany(OfficeSpacePhoto::class);
    }

    public function benefits()
    {
        return $this->hasMany(OfficeSpaceBenefit::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
