<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benchmark_structure extends Model
{
    use HasFactory;

    protected $guarded;

    public function benchmarkStructures()
    {
        return $this->hasMany(Benchmark_name::class, 'id', 'benchmark_name');
    }

}
