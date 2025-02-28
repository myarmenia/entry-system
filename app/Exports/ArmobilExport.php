<?php

namespace App\Exports;

use App\Traits\ReportTrait;
use App\Traits\ReportTraitArmobile;
use Carbon\Carbon;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Style;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
// use Maatwebsite\Excel\Concerns\Exportable;
// use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;




class ArmobilExport implements FromView, ShouldAutoSize
{
    use ReportTraitArmobile;


    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view():View{
        $groupedEntries = $this->report_armobile($this->request);
        $lastElement = end($groupedEntries);

        if (isset($groupedEntries['mounth'])) {
            unset($groupedEntries['mounth']);
        }

        return view('report.armobil',[

            "mounth" => $this->request,
            "groupedEntries" => $groupedEntries,
            "i" => 0

        ]);

    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:Z100')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
    }


}
