@extends('layouts.app')

@section("page-script")
    <script src="{{ asset('assets/js/change-status.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



@endsection

@section('content')
@php
    use Carbon\Carbon;
    use App\Helpers\TimeHelper;

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
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $item)
                                            @php
                                                $summary=0;
                                                $fullTime_arr=[];
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
                                                            $interval_arr = []

                                                        @endphp
                                                        @foreach ($attendant as $at )
                                                            @if ($item->people_id==$at->people_id)

                                                                @if (\Carbon\Carbon::parse($at->date)->format('d')==$date->format('d'))


                                                                        @if ($at->direction == "enter")
                                                                            @php
                                                                                $entry = new DateTime($at->date);
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
                                                            <span class="daySummary">+</span>
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

                                                        echo "{$totalHours1} ժ {$totalMinutes1} ր";

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


