<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    protected $fillable = [
        'name',
        'nilai_kriteria'
    ];
    protected $dates = [];
    protected $casts = [
        'nilai_kriteria' => 'array'
    ];
}
