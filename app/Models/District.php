<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['regency_id', 'code', 'name'];

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }
}