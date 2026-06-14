<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}