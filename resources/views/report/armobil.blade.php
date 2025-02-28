@php
    use Carbon\Carbon;

    use App\Models\AttendanceSheet;
    use Illuminate\Support\Facades\DB;



    // Assuming $request->month contains "2024-10"
    $monthYear = $mounth ?? null;
// dd( $monthYear);

    // Parse the month-year string to get the start and end of the month
    $startOfMonth = Carbon::parse($monthYear)->startOfMonth();
    $endOfMonth = Carbon::parse($monthYear)->endOfMonth();

    $groupedEntries = $groupedEntries ?? null;
dd( $groupedEntries)
@endphp
<main id="main" class="main">


    <section class="section">
      <div class="row">



        <div class="col-lg-12">

                <div class="card ">

                        <div class="card-body">
                            @if (session('create_client'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('create_client') }}
                                </div>
                            @endif


                            <div class = "d-flex justify-content-between">
                                @if (isset($error))
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endif
                                <h5 class="card-title">
                                    <nav>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item active">Հաշվետվություն ըստ մուտքի և ելքի</li>
                                        </ol>
                                    </nav>
                                </h5>
                                @php
                                    $day = \Carbon\Carbon::now()->format('l'); // 'l' gives the full name of the day (e.g., Monday, Tuesday)

                                @endphp


                            </div>


                          {{-- {{dd($groupedEntries)}} --}}
                            <!-- Bordered Table -->
                            @if((count($groupedEntries))>0)


                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">Հ/Հ</th>
                                                <th rowspan="2">ID</th>
                                                <th rowspan="2">Անուն</th>
                                                <th rowspan="2">Ազգանուն</th>

                                                @for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay())
                                                    <th colspan="2">{{ $date->format('d') }}</th>
                                                @endfor

                                                <th rowspan="2">Օրերի քանակ</th>
                                                <th rowspan="2">ժամերի քանակ</th>
                                                <th rowspan="2">Ուշացման ժամանակի գումար</th>
                                            </tr>
                                            <tr>
                                                @for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay())
                                                    <th>Մուտք</th>
                                                    <th>Ելք</th>
                                                @endfor
                                            </tr>
                                        </thead>
                                        <tbody>

                                            {{-- @foreach ($groupedEntries as $peopleId => $item)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $peopleId }}</td>
                                                    <td>{{ getPeople($peopleId)->name ?? null }}</td>
                                                    <td>{{ getPeople($peopleId)->surname ?? null }}</td>

                                                    @for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay())
                                                        <td class="p-0 text-center">
                                                            @if(isset($item[$date->format('d')]['enter']))

                                                                    <span>{{ $item[$date->format('d')]['enter'][0] }}</span><br>

                                                            @endif
                                                        </td>
                                                        <td class="p-0 text-center">
                                                            @if(isset($item[$date->format('d')]['exit']))
                                                            {{$item[$date->format('d')]['exit']}}



                                                                    <span>

                                                                        {{  last(array_slice($item[$date->format('d')]['exit'], -1))  }}

                                                                    </span><br>

                                                            @endif
                                                        </td>
                                                    @endfor

                                                    <td>{{ $item['totalMonthDayCount'] }}</td>
                                                    <td class="{{ isset($item['personWorkingTimeLessThenClientWorkingTime']) ? 'text-danger' : '' }}">
                                                        {{ $item['totalWorkingTimePerPerson'] }}
                                                    </td>
                                                    <td>{{ $item['totaldelayPerPerson'] }}</td>
                                                </tr>
                                            @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>

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

  </main>
