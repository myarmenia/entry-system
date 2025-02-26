<?php

namespace App\Exports;

use App\Traits\ReportTraitArmobile;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class ArmobilExport implements FromCollection
{
    use ReportTraitArmobile;


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


    }
    public function collection()
    {

        $groupedEntries = $this->report_armobile($this->request);
        $lastElement = end($groupedEntries);
        // dd($groupedEntries);
        // dd($lastElement);
        $this->month = $lastElement;
        // dd($groupedEntries);

        unset($groupedEntries['mounth']);
        $exportData = [];
        $i=0;

        foreach($groupedEntries as $peopleId =>$item){
            $i++;
            $dataRow = [
                "number"=>$i,
                'id' => $peopleId,
                'name' => getPeople($peopleId)->name ?? null ,
                'surname' => getPeople($peopleId)->surname ?? null,

            ];
            $daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;
            for ($day = 1; $day <= $daysInMonth; $day++) {

                if(isset($item[$day])){
                    if(isset($item[$day]['delay_display']) && isset($item[$day]['coming'])){
                        $dataRow[ $day] = "+ուշ";
                    }else if(isset($item[$day]['coming'])){
                        $dataRow[ $day] = "+";
                    }else if(isset($item[$day]['anomalia'])){
                        $dataRow[ $day] = "?";
                    }



                }else{
                    $dataRow[ $day] =null;
                }


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
