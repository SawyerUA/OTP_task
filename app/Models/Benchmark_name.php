<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benchmark_name extends Model
{
    use HasFactory;

    public function benchmark()
    {
        return $this->belongsTo(Benchmark::class, 'id', 'benchmark_name');
    }

    public function benchmarkStructures()
    {
        return $this->belongsTo(Benchmark_structure::class, 'id', 'benchmark_name');
    }




}
