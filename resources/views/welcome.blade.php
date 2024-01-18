<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
<section>
    <div id="data-container" class="container">
        <div class="row">
            <div class="">
                <div class="mt-5 mb-3 text-uppercase">
                    <span class="text-uppercase fw-bold">{{$data['benchTitle']}}</span> <span class="fw-lighter" style="font-size: 14px">from: {{\Carbon\Carbon::parse($data['dates']['dateFrom'])->format('d.m.Y')}}  to: {{\Carbon\Carbon::parse($data['dates']['dateTo'])->format('d.m.Y')}}
                    start: {{$data['start_index']}} active: {{$data['status'] == 1 ? 'true' : 'false'}}, стратегія: {{$data['strategy']}}, тип: {{$data['type']}}</span>
                </div>
                <div class="row">
                    <div class="col-auto">
                        <form method="get" action="{{route('filter')}}">
                            <div class="input-group">
                                <input class="form-control me-2" style="width: 10em" type="date" name="dateFrom">
                                <span class="me-2 mt-2"> to </span>
                                <input class="form-control" style="width: 10em" type="date" name="dateTo">
                                <button class="btn btn-secondary ms-2 rounded" type="submit">GO</button>
                            </div>
                        </form>
                        @error('dateFrom')
                        <p class="text-danger fw-bold fs-6 mt-3 fst-italic"> {{$message}} </p>
                        @enderror
                    </div>
                </div>

            </div>
            <table class="table table-striped mt-5">
                <thead>
                <tr>
                    <th scope="col">#</th>
{{--                    <th scope="col">name</th>--}}
                    <th scope="col">Інструмент</th>
                    <th scope="col">Доля</th>
                    <th scope="col">date</th>
                    <th scope="col">
                        <a href="{{route('indexFilter', ['sort' => request('sort', 'asc') === 'asc' ? 'desc' : 'asc'])}}">
                            <i class="btn sort_btn fa-solid fa-up-down"></i></a>benchmark
                    </th>
                    <th scope="col">
                        <a href="{{route('indexFilter', ['sort' => request('sort', 'asc') === 'asc' ? 'desc' : 'asc'])}}">
                            <i class="btn sort_btn fa-solid fa-up-down"></i></a>daily_growth
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($benchmarks as $key => $benchmark)
                    @foreach($benchmark->benchmarkNames as $benchmarkName)
                    <tr>
                        <td class="fw-bold"> {{$key+1}} </td>
{{--                        <td>{{$benchmark->benchmark_full_name}}</td>--}}
                        <td>{{$benchmarkName->benchmarkStructures->type}}</td>
                        <td>{{$benchmarkName->benchmarkStructures->exposure}}</td>
                        <td>{{\Carbon\Carbon::parse($benchmark->date)->format('d.m.Y D')}}</td>
                        <td>{{$benchmark->benchmark_index}}</td>
                        <td class="{{ strpos($benchmark->daily_growth, '-') !== false ? 'text-danger' : 'text-success' }}"> {{$benchmark->daily_growth}} </td>
                    </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
                <div class="mt-5 d-flex justify-content-end text-secondary">
                    {{$benchmarks->appends(request()->query())->links()}}
                </div>
        </div>
    </div>
</section>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<script src="https://kit.fontawesome.com/2ffbfd9d62.js" crossorigin="anonymous"></script>
</html>
