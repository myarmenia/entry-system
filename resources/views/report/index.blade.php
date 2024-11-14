@extends('layouts.app')

@section("page-script")
    <script src="{{ asset('assets/js/change-status.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



@endsection

@section('content')
@php
    use Carbon\Carbon;

    // Assuming $request->month contains "2024-10"
    $monthYear = $mounth;

    // Parse the month-year string to get the start and end of the month
    $startOfMonth = Carbon::parse($monthYear)->startOfMonth();
    $endOfMonth = Carbon::parse($monthYear)->endOfMonth();
    // dd($startOfMonth);
// dd($startOfMonth->lte($endOfMonth));
// dd($startOfMonth->addDay());

$entry = new DateTime('2024-10-01 09:42:48');
$exit = new DateTime('2024-10-01 18:00:00');

$interval = $entry->diff($exit);
echo $interval->format('%H hours %I minutes');

// dd($interval->format('%H hours %I minutes'));

@endphp
{{-- <ul>
    @for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay())
        <li>{{ $date->format('m-d') }}</li> <!-- Displays each day in "YYYY-MM-DD" format -->
    @endfor
</ul> --}}

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
                            @if($attendant1!=null)


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
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $item)
                                    @php
                                        $summary=0;
                                        $fullTime="";
                                        $intervals = [];
                                    @endphp
                                        <tr class="parent">
                                            <td>{{ $item->id }}</td>
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
                                                    @endphp
                                                    @foreach ($attendant1 as $at )
                                                        @if ($item->people_id==$at->people_id)

                                                            @if (\Carbon\Carbon::parse($at->date)->format('d')==$date->format('d'))
                                                                    @php
                                                                        // $enter = '';
                                                                        // $exit = '';
                                                                    @endphp

                                                                    @if ($at->direction == "enter")
                                                                        @php
                                                                            $entry = new DateTime($at->date);
                                                                        @endphp
                                                                    @else
                                                                        @php
                                                                           $exit = new DateTime($at->date);
                                                                           $interval = $entry->diff($exit);
                                                                           echo $interval->format('%H h %I m');

                                                                        @endphp
                                                                    @endif

                                                                @php
                                                                //  echo $interval->format('%H h %I m');
                                                                    // $interval = $entry->diff($exit);

                                                                    $count++;
                                                                @endphp
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    @if($count>0)
                                                        <span class="daySummary">+</span>
                                                        @php
                                                           $summary++;
                                                        @endphp

                                                    @endif
                                                </td>
                                            @endfor
                                            <td>
                                                {{  $summary }}
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


