@extends('layouts.app')

@section("page-script")
    <script src="{{ asset('assets/js/change-status.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        th{
            font-size:12px
        }
    </style>
@endsection


@section('content')
@php
    use Carbon\Carbon;

    use App\Models\AttendanceSheet;
    use Illuminate\Support\Facades\DB;



    // Assuming $request->month contains "2024-10"
    $monthYear = $mounth;

    // Parse the month-year string to get the start and end of the month
    $startOfMonth = Carbon::parse($monthYear)->startOfMonth();
    $endOfMonth = Carbon::parse($monthYear)->endOfMonth();

@endphp



   <main id="main" class="main">


    <section class="section">
      <div class="row">



        <div class="col-lg-12">

                <div class="card">

                        <div class="card-body">
                            @if (session('create_client'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('create_client') }}
                                </div>
                            @endif

                            <div class = "d-flex justify-content-between">
                                <h5 class="card-title">
                                    <nav>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item active">Հաշվետվություն</li>
                                        </ol>
                                    </nav>
                                </h5>
                                @php
                                    $day = \Carbon\Carbon::now()->format('l'); // 'l' gives the full name of the day (e.g., Monday, Tuesday)

                                @endphp


                            </div>

                            <form  action="{{ route('reportList') }}" method="get" class="mb-3 justify-content-end" style="display: flex; gap: 8px">

                                <div class="col-2">
                                    <input type="text"  class="form-select"  id="monthPicker" placeholder="Ընտրել ամիսը տարեթվով" name="mounth"/>
                                </div>
                                <button type="submit" class="btn btn-primary col-2 search">Հաշվետվություն</button>
                            </form>
                            <!-- Bordered Table -->
                            @if(($groupedEntries)>0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Հ/Հ</th>
                                            <th scope="col">ID</th>
                                            <th scope="col">Անուն</th>
                                            <th scope="col">Ազգանուն</th>

                                            @for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay())
                                                <th>{{ $date->format('d') }}</th> <!-- Displays each day in "YYYY-MM-DD" format -->
                                            @endfor
                                            <th>Օրերի քանակ</th>
                                            <th>ժամերի քանակ</th>
                                            <th>Ուշացման ժամանակի գումար</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        {{-- {{ dd ($groupedEntries)}} --}}
                                        @foreach ($groupedEntries as $peopleId=>$item)

                                            {{-- @dump($item) --}}

                                            <tr class="parent">
                                                <td>{{ ++$i }}</td>
                                                <td scope="row">{{ $peopleId }}</td>
                                                <td class="personName">
                                                    {{ getPeople($peopleId)->name ?? null }}
                                                </td>
                                                <td class="personSurname">
                                                    {{ getPeople($peopleId)->surname ?? null }}
                                                </td>
                                                @for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay())

                                                    <td class="p-0 text-center">



                                                        @if(isset($item[$date->format('d')]))



                                                            @if (isset($item[$date->format('d')]['delay_display']))

                                                                <div class="{{ isset($item[$date->format('d')]['delay_display'])?'bg-danger':null}}"> +</div>

                                                            @elseif (isset($item[$date->format('d')]['anomalia']))

                                                            <div class="{{ isset($item[$date->format('d')]['anomalia'])?'bg-warning':null}}"> ?</div>

                                                            @elseif(isset($item[$date->format('d')]['coming']))
                                                                +
                                                            @endif
                                                        @endif
                                                    </td>
                                                @endfor
                                                <td>
                                                    {{$item['totalMonthDayCount'] }}

                                                </td>
                                                <td>

                                                    <span class="{{ isset($item['personWorkingTimeLessThenClientWorkingTime']) ? 'text-danger' : null  }}">
                                                        {{$item['totalWorkingTimePerPerson'] }}
                                                     <span>

                                                </td>
                                                <td>
                                                    {{$item['totaldelayPerPerson'] }}
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @endif

                            <!-- End Bordered Table -->
                            <div class="demo-inline-spacing">
                                {{-- {{ $data->links() }} --}}
                            </div>
                        </div>



                </div>



        </div>

      </div>

    </section>

  </main><!-- End #main -->

@endsection

