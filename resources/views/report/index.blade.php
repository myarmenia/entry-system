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
    use App\Helpers\TimeHelper;
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
                            @if($attendant)
                                <div>
                                    <div>
                                        <div></div>
                                        <p></p>
                                    </div>
                                </div>
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


                                        @foreach ($data as $item)
                                            @php
                                                $summary=0;
                                                $fullTime_arr=[];




                                                $delay_arr = [];
                                            @endphp
                                            <tr class="parent">

                                                <td>{{ ++$i }}</td>
                                                <td scope="row">{{ $item->people_id }}</td>

                                                <td class="personName">
                                                    {{ $item->people->name ?? null }}

                                                </td>
                                                <td class="personSurname">
                                                    {{ $item->people->surname ?? null }}
                                                </td>


                                                @for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay())
                                                    @php

                                                       $delay_color=false;

                                                    @endphp

                                                <td class="p-0">
                                                        @php
                                                            $count=0;
                                                            $interval_arr = [];
                                                            // $delay_color=false;


                                                            $key=0;


                                                        @endphp

                                                        @foreach ($attendant as $at )

                                                                    {{-- {{ 71 }} --}}




                                                            @if ($item->people_id==$at->people_id)



                                                                      {{-- {{ $at->people_id }} --}}


                                                                @if (\Carbon\Carbon::parse($at->date)->format('d')==$date->format('d'))
                                                                            {{-- {{ 73 }} --}}



                                                                        @if ($at->direction == "enter")
                                                                            {{-- {{ 74 }} --}}
                                                                            @php
                                                                                $key++;
                                                                             @endphp


                                                                            @php
                                                                                $entry = new DateTime($at->date);

                                                                                    $get_day = \Carbon\Carbon::parse($entry)->format('l');

                                                                                    foreach($client_working_day_times as $day_time){

                                                                                        if($day_time->week_day==$get_day){
                                                                                                    if($key==1 ){


                                                                                                        $firstAfter840 = DB::table('attendance_sheets')
                                                                                                            ->where('direction', 'enter')
                                                                                                            ->where('people_id', $at->people_id)
                                                                                                            ->whereDate('date', date('Y-m-d', strtotime($at->date)))

                                                                                                            ->orderBy('date', 'asc') // Сортируем по времени
                                                                                                            ->first();
                                                                                                        //    dd($firstAfter840) ;


                                                                                                          $delay_couny=false;
                                                                                                            if($firstAfter840){


                                                                                                                $datePart = explode(' ', $firstAfter840->date)[1];

                                                                                                                            $time1 = new DateTime($datePart);

                                                                                                                            $time2 = new DateTime($day_time->day_start_time);

                                                                                                                            $interval = $time1->diff($time2);
                                                                                                                            // dd($interval);
                                                                                                                            if($time1 >$time2){
                                                                                                                                $delay_arr[] = $interval->format('%H h %I m');
                                                                                                                                $delay_color = true;

                                                                                                                            }



                                                                                                            }
                                                                                                            $breakfastInterval = DB::table('attendance_sheets')
                                                                                                            ->where('people_id', $at->people_id)
                                                                                                            ->whereDate('date', date('Y-m-d', strtotime($at->date)))
                                                                                                            ->whereTime('date', '>=', $day_time->break_start_time) // Время после 08:40
                                                                                                            ->whereTime('date', '<=', $day_time->break_end_time)
                                                                                                            ->orderBy('date', 'desc') // Сортируем по времени
                                                                                                            ->limit(2)
                                                                                                            ->pluck('date','direction');
                                                                                                            // dd($breakfastInterval);


                                                                                                            $ushacum=false;
                                                                                                            if(count($breakfastInterval)>0){

                                                                                                                if(count($breakfastInterval)==1 && isset($breakfastInterval["exit"])){
                                                                                                                    $ushacum=true;


                                                                                                                }
                                                                                                                if(count($breakfastInterval)>1 ){


                                                                                                                    $enterTime = new DateTime($breakfastInterval['enter']);
                                                                                                                        $exitTime = new DateTime($breakfastInterval['exit']);
                                                                                                                        // dump($enterTime,$exitTime);


                                                                                                                        if ($exitTime > $enterTime) {
                                                                                                                            $ushacum=true;

                                                                                                                            // dump($delay_arr);

                                                                                                                        }



                                                                                                                }



                                                                                                            }
                                                                                                            else{

                                                                                                                $firstActionAfterBreakfast = DB::table('attendance_sheets')

                                                                                                                        ->where('people_id', $at->people_id)
                                                                                                                        ->whereDate('date', date('Y-m-d', strtotime($at->date)))
                                                                                                                        ->whereTime('date', '>', $day_time->break_end_time) // Время после 14:00
                                                                                                                        ->orderBy('date', 'asc') // Сортируем по времени
                                                                                                                        ->first();



                                                                                                                        if( isset($firstActionAfterBreakfast->direction) && $firstActionAfterBreakfast->direction=="enter"){
                                                                                                                            // dump($firstActionAfterBreakfast);
                                                                                                                            $ushacum=true;
                                                                                                                        }

                                                                                                            }
                                                                                                            if($ushacum==true){


                                                                                                                    $firstAfter1400 = DB::table('attendance_sheets')
                                                                                                                        ->where('direction', 'enter')
                                                                                                                        ->where('people_id', $at->people_id)
                                                                                                                        ->whereDate('date', date('Y-m-d', strtotime($at->date)))
                                                                                                                        ->whereTime('date', '>', $day_time->break_end_time) // Время после 14:00
                                                                                                                        ->orderBy('date', 'asc') // Сортируем по времени
                                                                                                                        ->first();
                                                                                                                        dd(11,$firstAfter1400);


                                                                                                                        if($firstAfter1400){


                                                                                                                            $firstAfter1400_datePart = explode(' ', $firstAfter1400->date)[1];

                                                                                                                                        $firstAfter1400_time1 = new DateTime($firstAfter1400_datePart);

                                                                                                                                        $firstAfter1400_time2 = new DateTime($day_time->break_end_time);

                                                                                                                                        $firstAfter1400_interval = $firstAfter1400_time1 ->diff($firstAfter1400_time2);

                                                                                                                            if($firstAfter1400_interval->format('%H h %I m')!=="00 h 00 m"){

                                                                                                                                $delay_arr[] = $firstAfter1400_interval->format('%H h %I m');
                                                                                                                                $delay_color = true;



                                                                                                                            }

                                                                                                                            }

                                                                                                            }


                                                                                                    }



                                                                                        }
                                                                                    }







                                                                            @endphp
                                                                        @else
                                                                            @php
                                                                            // dump($at->date);
                                                                            if(isset($entry)){
                                                                                $exit = new DateTime($at->date);
                                                                                if(isset($entry)){
                                                                                    $interval = $entry->diff($exit);

                                                                                    //    echo $interval->format('%H h %I m');
                                                                                    $interval_arr[] = $interval->format('%H h %I m');
                                                                                    // dump($interval_arr);
                                                                                }

                                                                            }


                                                                            @endphp
                                                                        @endif
                                                                    @php
                                                                        $count++;
                                                                    @endphp
                                                                @endif
                                                            @endif
                                                        @endforeach

                                                        @if($count>0)
                                                            <span style="width:50px" class="daySummary w-100 {{ $delay_color==true?'bg-danger':null}}">+</span>

                                                            @php $summary++; @endphp

                                                        @endif
                                                        @php
                                                        // dd($interval_arr);
                                                            $totalHours = 0;
                                                            $totalMinutes = 0;

                                                            foreach ($interval_arr as $time) {
                                                                // Extract hours and minutes using regex
                                                                preg_match('/(\d+) h (\d+) m/', $time, $matches);
                                                                if ($matches) {
                                                                    $hours = (int)$matches[1];
                                                                    $minutes = (int)$matches[2];

                                                                    // Add to the total hours and minutes
                                                                    $totalHours += $hours;
                                                                    $totalMinutes += $minutes;
                                                                }
                                                            }

                                                            // Convert total minutes to hours and minutes
                                                            $totalHours += floor($totalMinutes / 60);
                                                            $totalMinutes = $totalMinutes % 60;

                                                            // echo "{$totalHours} h {$totalMinutes} m";
                                                            $fullTime_arr[]="{$totalHours} h {$totalMinutes} m";
                                                            // dd($fullTime_arr)
                                                        @endphp


                                                    </td>
                                                @endfor
                                                <td>
                                                    {{ $summary }}
                                                </td>
                                                <td>
                                                    @php
                                                        $totalHours1 = 0;
                                                        $totalMinutes1 = 0;

                                                        foreach ($fullTime_arr as $time) {

                                                            // Extract hours and minutes using regex
                                                            preg_match('/(\d+) h (\d+) m/', $time, $matches);
                                                            if ($matches) {

                                                                $hours = (int)$matches[1];
                                                                $minutes = (int)$matches[2];

                                                                // Add to the total hours and minutes
                                                                $totalHours1 += $hours;
                                                                $totalMinutes1 += $minutes;
                                                            }
                                                        }

                                                        // Convert total minutes to hours and minutes

                                                        $totalHours1 += floor($totalMinutes1 / 60);
                                                        $totalMinutes1 = $totalMinutes1 % 60;

                                                        $client_working_time=$client->working_time*1;


                                                        // echo "{$totalHours1} ժ {$totalMinutes1} ր";

                                                    @endphp
                                                      <span class=" {{ $totalHours1<$client->working_time*1?'text-danger':null}}">{{$totalHours1}} ժ {{$totalMinutes1}} ր</span>
                                                </td>
                                                <td>
                                                    @php

                                                        $delayHours = 0;
                                                        $delayMinutes = 0;

                                                        foreach ($delay_arr as $delay) {
                                                            // Extract hours and minutes using regex
                                                            preg_match('/(\d+) h (\d+) m/', $delay, $matches);
                                                            if ($matches) {

                                                                $hours = (int)$matches[1];
                                                                $minutes = (int)$matches[2];

                                                                // Add to the total hours and minutes
                                                                $delayHours += $hours;
                                                                $delayMinutes += $minutes;
                                                            }
                                                        }

                                                        // Convert total minutes to hours and minutes

                                                        $delayHours += floor($delayMinutes / 60);
                                                        $delayMinutes = $delayMinutes % 60;

                                                        echo "{$delayHours} ժ {$delayMinutes} ր";


                                                    @endphp

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


