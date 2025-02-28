<?php

namespace App\Exports;

use App\Traits\ReportTrait;
use App\Traits\ReportTraitArmobile;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Style;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;




class ArmobilExport implements FromView, ShouldAutoSize
// FromCollection
// , WithHeadings,WithStyles,ShouldAutoSize, WithEvents

{
    use ReportTraitArmobile;
    use Exportable;



    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;
    protected $year;
    protected $month;
    protected $aa;
    public function __construct($request,$year=null, $month=null)
    {

        $this->request = $request;
        $this->year = $year ?? now()->year;
        $this->month = $month ?? now()->month;

    }
    public function collection()
    {
        // dd($this->request);
        $groupedEntries = $this->report_armobile($this->request);
        // dd($groupedEntries);
        $lastElement = end($groupedEntries);

        // dd($lastElement);
        $this->month = $lastElement;
        // dd($groupedEntries);


        if (isset($groupedEntries['mounth'])) {
            unset($groupedEntries['mounth']);
        }

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
            // dd($daysInMonth);
            for ($day = 1; $day <= $daysInMonth; $day++) {
                // dd($day);


                if(isset($item[$day])){
                    if(isset($item[$day]['enter'])){
                        $dataRow[ $day]['enter']= $item[$day]['enter'][0];
                    }
                    if(isset($item[$day]['exit'])){
                        $dataRow[ $day]['exit']= end($item[$day]['exit']);
                    }

                }else{
                    $dataRow[ $day] = null;
                    $dataRow[ $day]['enter'] = null;
                    $dataRow[ $day]['exit'] = null;
                }

            }

            $dataRow["totalMonthDayCount"]=$item['totalMonthDayCount'];
            $dataRow["totalWorkingTimePerPerson"]=$item['totalWorkingTimePerPerson'];
            $dataRow["totaldelayPerPerson"]=$item['totaldelayPerPerson'];

            $exportData[] = $dataRow;
        }
        // dd(collect($exportData));
        return collect($exportData);
    }


//     public function headings(): array
//     {

//     $daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;
//     $dayHeaders = [];

//     // Add headers for each day with a merged cell for "enter" and "exit"
//     for ($day = 1; $day <= $daysInMonth; $day++) {
//         $dayHeaders[] = $day; // Day header

//     }

//     // Create header rows
//     $fixedHeaders = ['Հ/Հ', 'ID', 'Անուն', 'Ազգանուն']; // Fixed headers
//     $dynamicHeaders = []; // Dynamic headers for each day
//     $enterExitHeaders = []; // To hold Enter and Exit headers

//     // Add "enter" and "exit" labels under each day
//     foreach ($dayHeaders as $day) {

//         $dynamicHeaders[] = $day; // Day number
//         // $dynamicHeaders[] = 'Enter'; // Enter label
//         // $dynamicHeaders[] = 'Exit'; // Exit label
//         $enterExitHeaders[] = 'Enter'; // Enter label for the day
//         $enterExitHeaders[] = 'Exit'; // Exit label for the day
//     }
//     // dd($dynamicHeaders);
//     // foreach($dynamicHeaders as $exent){
//     //     $exent[]['Enter']='Enter';
//     //     $exent[]['exit']='Exit';

//     // }
//     //  dd($dynamicHeaders);

//     // Merge fixed headers with dynamic headers

//     $allHeaders = array_merge(
//         $fixedHeaders,
//         $dynamicHeaders,
//         $enterExitHeaders,
//         ['Օրերի քանակ', 'ժամերի քանակ', 'Ուշացման ժամանակի գումար'] // Additional headers
//     );

//      // Log the headers to check the output
//     //  logger($allHeaders);
//     // dd($allHeaders);
//      return $allHeaders;

// }
    // public function styles(Worksheet $sheet)
    // {
    // // dd($sheet);
    //     // Start styling from the second row onward (data rows)
    //     $rowStart = 2;



    //     // Loop through rows and check for "+", then set the style
    //     foreach ($sheet->getRowIterator($rowStart) as $row) {

    //         $rowIndex = $row->getRowIndex();


    //         foreach ($sheet->getColumnIterator('A') as $column) { // Starting from the "D" column
    //             $cell = $sheet->getCell($column->getColumnIndex() . $rowIndex);
    //             // dd(  $cell->getValue());
    //             // if ($cell->getValue() == "+ուշ") {
    //             //     $sheet->getStyle($cell->getCoordinate())->getFont()->getColor()->setRGB('FF0000'); // Red
    //             // }

    //         }
    //     }
    // }
    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
    //             $event->sheet->getDelegate()->mergeCells('A1:C1'); // Объединение заголовков
    //             $event->sheet->getDelegate()->getStyle('A1')->getAlignment()->setHorizontal('center');
    //         }
    //     ];
    // }
    public function view():View{
        $groupedEntries = $this->report_armobile($this->request);
        // dd($groupedEntries);
        $lastElement = end($groupedEntries);

        // dd($lastElement);
        $this->month = $lastElement;
        // dd($groupedEntries);


        if (isset($groupedEntries['mounth'])) {
            unset($groupedEntries['mounth']);
        }
        // dd($groupedEntries);
        // dd($this->collection());
        return view('report.aa',[
            "mounth" => $this->month,
            // "groupedEntries" => $this->collection(),
            "groupedEntries" => $groupedEntries,
            "i" => 0

        ]);

    }

}
