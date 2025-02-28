<!DOCTYPE html>


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Armobil</title>

</head>
@php
    use Carbon\Carbon;

    use App\Models\AttendanceSheet;
    use Illuminate\Support\Facades\DB;
    // $request->month contains "2024-10"
    $monthYear = $mounth ?? null;
// dd( $monthYear);

    // Parse the month-year string to get the start and end of the month
    // $startOfMonth = Carbon::parse($monthYear)->startOfMonth()->toDateString();
    // $endOfMonth = Carbon::parse($monthYear)->endOfMonth()->toDateString();
    $startOfMonth = Carbon::parse("$monthYear-01")->startOfMonth();
    $endOfMonth = Carbon::parse("$monthYear-01")->endOfMonth();
    $groupedEntries = $groupedEntries ?? null;

@endphp

<body>
    <div>

        <table>
            <thead>
                <tr>
                    <td colspan="20" >Հաշվետվություն {{ $monthYear }}-ի դրությամբ</td>

                </tr>
                <tr>


                </tr>

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
                @foreach ($groupedEntries as $peopleId => $item)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $peopleId }}</td>
                        <td>{{ getPeople($peopleId)->name ?? null }}</td>
                        <td>{{ getPeople($peopleId)->surname ?? null }}</td>
                    </tr>
                    @for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay())
                        <td class="p-0 text-center">
                            @if(isset($item[$date->format('d')]['enter']))

                                    <span>{{ $item[$date->format('d')]['enter'][0] }}</span><br>

                            @endif
                        </td>
                        <td class="p-0 text-center">

                           @if(isset($item[$date->format('d')]['exit']))
                                    <span>
                                        {{ end($item[$date->format('d')]['exit']) }}

                                    </span><br>

                            @endif
                        </td>
                    @endfor
                    <td>{{ $item['totalMonthDayCount'] }}</td>
                    <td class="{{ isset($item['personWorkingTimeLessThenClientWorkingTime']) ? 'text-danger' : '' }}">
                        {{ $item['totalWorkingTimePerPerson'] }}
                        </td>
                    <td>{{ $item['totaldelayPerPerson'] }}</td>

                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>

