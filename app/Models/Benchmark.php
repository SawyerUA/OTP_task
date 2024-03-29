<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benchmark extends Model
{
    use HasFactory;

    protected $guarded;

    public function benchmarkNames()
    {
        return $this->hasMany(Benchmark_name::class, 'id', 'benchmark_name');
    }



}
