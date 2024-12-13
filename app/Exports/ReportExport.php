<?php

namespace App\Exports;

use App\Traits\ReportTrait;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class ReportExport implements  FromCollection, WithHeadings
{
    use ReportTrait;
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $request;
    protected $year;
    protected $month;
    public function __construct($request,$year=null, $month=null)
    {
        $this->request = $request;
        $this->year = $year ?? now()->year;
        $this->month = $month ?? now()->month;
        // dd($this->year);

    }
    public function collection()
    {
        // Use the trait's report logic
        $groupedEntries = $this->report($this->request);
        // dd($groupedEntries);
        $lastElement = end($groupedEntries);
        $this->month = $lastElement;
        // dd($this->month);

        unset($groupedEntries['mounth']);
        // dd($lastElement, $groupedEntries);


        $exportData = [];
        $i=0;
        foreach($groupedEntries as $peopleId =>$item){
            $i++;
            // dd($peopleId,$item);
            $dataRow = [
                "number"=>$i,
                'id' => $peopleId,
                'name' => getPeople($peopleId)->name ?? null ,
                'surname' => getPeople($peopleId)->surname ?? null,

            ];
            $daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;
            for ($day = 1; $day <= $daysInMonth; $day++) {

                if(isset($item[$day])){
                    // dd($item[$day]);
                }

                $dataRow['Day ' . $day] = $days[$day] ?? null; // Use null for missing days
            }

            $dataRow["totalMonthDayCount"]=$item['totalMonthDayCount'];
            $dataRow["totalWorkingTimePerPerson"]=$item['totalWorkingTimePerPerson'];
            $dataRow["totaldelayPerPerson"]=$item['totaldelayPerPerson'];

            $exportData[] = $dataRow;

        }
        return collect($exportData);
    }
    public function headings(): array
    {
        // Dynamically create headers including each day from 1 to 31
        $daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;
        $dayHeaders = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dayHeaders[] =   $day;
        }

        return array_merge(
            ['Հ/Հ',	'ID','Անուն','Ազգանուն' ],  // Fixed headers
            $dayHeaders ,['Օրերի քանակ','ժամերի քանակ','Ուշացման ժամանակի գումար'] // Day headers (Day 1 to Day 31)
        );
    }
}
