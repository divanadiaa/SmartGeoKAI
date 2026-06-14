<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_asset',
        'province_id',
        'regency_id',
        'district_id',
        'asset_type',
        'classification',
        'asset_group',
        'status',
        'area_m2',
        'latitude',
        'longitude',
        'description',
        'gmaps_url',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'area_m2' => 'decimal:2',
            'latitude' => 'decimal:10',
            'longitude' => 'decimal:10',
        ];
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function images()
    {
        return $this->hasMany(AssetImage::class);
    }

    public function documents()
    {
        return $this->hasMany(AssetDocument::class);
    }

    public function histories()
    {
        return $this->hasMany(AssetHistory::class);
    }
}