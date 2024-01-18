<?php

namespace App\Http\Controllers;


use App\Http\Requests\BenchmarkRequest;
use App\Models\Benchmark;
use App\Models\Benchmark_name;
use Carbon\Carbon;
use Illuminate\Http\Request;
class IndexController extends Controller
{
    private $benchType;
    private $benchFilterType;
    private $sort;

    public function __construct(){

        $benchFullName = 'benchmark_eqf_2023_IS';

        $this->benchType = Benchmark::where('benchmark_full_name', $benchFullName)->orderBy('date', 'DESC')->paginate(10);

        $this->sort = request()->input('sort', 'asc');

        $this->benchFilterType = Benchmark::where('benchmark_full_name', $benchFullName)
            ->orderBy('benchmark_index', $this->sort)
            ->paginate(10);
    }

    public function index(){

        $benchmarks = $this->benchType;

        foreach ($benchmarks as $bench){
            $benchIndex = Benchmark_name::where('name', $bench->benchmark_full_name)->whereNotNull('active')->get();
            foreach ($benchIndex as $index){
                $data = [
                    'benchTitle' => $bench->benchmark_full_name,
                    'dates' =>
                        [
                            'dateFrom' => $benchmarks->min('date'),
                            'dateTo' => $benchmarks->max('date'),
                        ],
                    'start_index' => $index->start_index,
                    'strategy' => $index->strategy,
                    'type' => $index->type,
                    'status' => $index->active
                ];
            }
        }

        return view('welcome', compact('benchmarks', 'data'));
    }

//    Фильтр по дате
    public function filter(BenchmarkRequest $request){

        $benchmarks = $this->benchType;

        foreach($benchmarks as $benchmark){
            $benchmark = $benchmark->benchmark_full_name;

            $benchMarkList = Benchmark_name::where('name', $benchmark)->whereNotNull('active')->get();

            foreach ($benchMarkList as $bench){
                $data = [
                    'benchTitle' => $bench->name,
                    'dates' =>
                        [
                            'dateFrom' => $request->input('dateFrom'),
                            'dateTo' => $request->input('dateTo') == null ? Carbon::now() : $request->input('dateTo'),
                        ],
                    'start_index' => $bench->start_index,
                    'strategy' => $bench->strategy,
                    'type' => $bench->type,
                    'status' => $bench->active
                ];

            }
        }

        $filteredBenchmarks = Benchmark::whereBetween('date', [$data['dates']['dateFrom'], $data['dates']['dateTo']])->where('benchmark_full_name', $benchmark)
            ->orderBy('date', 'DESC')
            ->paginate(10)->withQueryString();

        return view('filter', compact('benchmarks', 'data', 'filteredBenchmarks'));
    }

//    Фильтр по индексу бенчмарки
    public function indexFilter(){

        $benchmarks = $this->benchFilterType;

        foreach ($benchmarks as $bench){
            $benchIndex = Benchmark_name::where('name', $bench->benchmark_full_name)->whereNotNull('active')->get();
            foreach ($benchIndex as $index){
                $data = [
                    'benchTitle' => $bench->benchmark_full_name,
                    'dates' =>
                        [
                            'dateFrom' => $benchmarks->min('date'),
                            'dateTo' => $benchmarks->max('date'),
                        ],
                    'start_index' => $index->start_index,
                    'strategy' => $index->strategy,
                    'type' => $index->type,
                    'status' => $index->active
                ];
            }
        }

        return view('welcome', compact('benchmarks', 'data'));

    }
}
