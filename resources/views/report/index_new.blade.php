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
                                    echo $day;
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

                                                $delay_color=false;

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
                                                    <td>
                                                        @php
                                                            $count=0;
                                                            $interval_arr = [];


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
                                                                                            // echo "-";
                                                                                            // dd($at->people_id );
                                                                                            $model=DB::table('attendance_sheets')
                                                                                                        ->where('direction', "enter")
                                                                                                        ->where('people_id', $at->people_id)
                                                                                                        ->whereDate('date', date('Y-m-d', strtotime($at->date)))
                                                                                                        ->get()->toArray();

                                                                                                        // ===========

                                                                                                            // dd($firstAfter840 ,$firstAfter1400);
                                                                                                        // =======

                                                                                                        // =======






                                                                                                    if($key==1 ){

                                                                                                        $firstAfter840 = DB::table('attendance_sheets')
                                                                                                            ->where('direction', 'enter')
                                                                                                            ->where('people_id', $at->people_id)
                                                                                                            ->whereDate('date', date('Y-m-d', strtotime($at->date)))
                                                                                                            ->whereTime('date', '>', '08:40:00') // Время после 08:40
                                                                                                            ->orderBy('date', 'asc') // Сортируем по времени
                                                                                                            ->first();
                                                                                                        $firstAfter1400 = DB::table('attendance_sheets')
                                                                                                                        ->where('direction', 'enter')
                                                                                                                        ->where('people_id', $at->people_id)
                                                                                                                        ->whereDate('date', date('Y-m-d', strtotime($at->date)))
                                                                                                                        ->whereTime('date', '>', '14:00:00') // Время после 14:00
                                                                                                                        ->orderBy('date', 'asc') // Сортируем по времени
                                                                                                                        ->first();
                                                                                                        $delay_couny=false;
                                                                                                        if($firstAfter840){


                                                                                                            $datetime_people_start_time = Carbon::parse( $firstAfter840->date);

                                                                                                            $peopleHourMinute = $datetime_people_start_time->format('H:i');

                                                                                                            $people_start_time = Carbon::createFromFormat('H:i', $peopleHourMinute);
                                                                                                            $client_start_time = Carbon::parse($day_time->day_start_time);

                                                                                                            $delay = $people_start_time->diff($client_start_time);

                                                                                                            $delay_arr[] = $delay->format('%H h %I m');
                                                                                                            if($delay->format('%H h %I m')!="00 h 00 m"){
                                                                                                                $delay_color = true;
                                                                                                                // dump($delay_color);
                                                                                                            }
                                                                                                            // dump($delay_arr);
                                                                                                        }
                                                                                                        if($firstAfter1400){
                                                                                                            $datetime_people_time = Carbon::parse( $firstAfter1400->date);
                                                                                                            $datetimeHourMinute = $datetime_people_time->format('H:i');
                                                                                                            $people_time = Carbon::createFromFormat('H:i', $datetimeHourMinute);
                                                                                                            $client_break_end_credental = Carbon::parse($day_time->break_end_time);
                                                                                                            $people_credental= Carbon::parse($people_time);
                                                                                                                if( $people_credental->greaterThan($client_break_end_credental  )){

                                                                                                                            $delay_couny=true;


                                                                                                                        $delay_break_end_time = $people_credental->diff($client_break_end_credental);
                                                                                                                        $delay_arr[]=$delay_break_end_time->format('%H h %I m');
                                                                                                                        // dump($delay_arr);
                                                                                                                        $delay_color=true;
                                                                                                                        // dump($delay_color);
                                                                                                                        break;

                                                                                                                }

                                                                                                        }
                                                                                                         dump($delay_arr);



                                                                                                        // foreach($model as $m=>$mod){




                                                                                                        //     if($m==0){


                                                                                                        //         $datetime_people_start_time = Carbon::parse( $mod->date);

                                                                                                        //         $peopleHourMinute = $datetime_people_start_time->format('H:i');

                                                                                                        //         $people_start_time = Carbon::createFromFormat('H:i', $peopleHourMinute);
                                                                                                        //         $client_start_time = Carbon::parse($day_time->day_start_time);

                                                                                                        //         $delay = $people_start_time->diff($client_start_time);

                                                                                                        //         $delay_arr[] = $delay->format('%H h %I m');
                                                                                                        //         if($delay->format('%H h %I m')!="00 h 00 m"){
                                                                                                        //             $delay_color = true;
                                                                                                        //             // dump($delay_color);
                                                                                                        //         }

                                                                                                        //     }
                                                                                                        //     else{

                                                                                                        //         if($delay_couny==false){

                                                                                                        //             $datetime_people_time = Carbon::parse( $mod->date);
                                                                                                        //                 $datetimeHourMinute = $datetime_people_time->format('H:i');
                                                                                                        //                 $people_time = Carbon::createFromFormat('H:i', $datetimeHourMinute);
                                                                                                        //                 $client_break_end_credental = Carbon::parse($day_time->break_end_time);
                                                                                                        //                 $people_credental= Carbon::parse($people_time);
                                                                                                        //             if( $people_credental->greaterThan($client_break_end_credental  )){

                                                                                                        //                         $delay_couny=true;


                                                                                                        //                     $delay_break_end_time = $people_credental->diff($client_break_end_credental);
                                                                                                        //                     $delay_arr[]=$delay_break_end_time->format('%H h %I m');
                                                                                                        //                     dump($delay_arr);
                                                                                                        //                     $delay_color=true;
                                                                                                        //                     // dump($delay_color);
                                                                                                        //                     break;

                                                                                                        //             }
                                                                                                        //         }

                                                                                                        //     }


                                                                                                        // }
                                                                                                    }else{
                                                                                                        dump(100);
                                                                                                    }



                                                                                        }
                                                                                    }







                                                                            @endphp
                                                                        @else
                                                                            @php
                                                                                $exit = new DateTime($at->date);
                                                                                $interval = $entry->diff($exit);

                                                                                //    echo $interval->format('%H h %I m');
                                                                                $interval_arr[] = $interval->format('%H h %I m');

                                                                            @endphp
                                                                        @endif
                                                                    @php
                                                                        $count++;
                                                                    @endphp
                                                                @endif
                                                            @endif
                                                        @endforeach

                                                        @if($count>0)
                                                            <span class="daySummary {{ $delay_color==true?'text-danger':null}}">+</span>
                                                            @php $summary++; @endphp

                                                        @endif
                                                        @php
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
  <script>
//     flatpickr("#yearPicker", {
//       dateFormat: "Y", // Year only
//       defaultDate: new Date().getFullYear().toString() // Optional default
//     });

//     flatpickr("#monthPicker", {
//     plugins: [
//       new flatpickr.monthSelectPlugin({
//         shorthand: true, // Display short month names
//         dateFormat: "Y-m", // Format as YYYY-MM
//       })
//     ]
//   });
</script>

@endsection


