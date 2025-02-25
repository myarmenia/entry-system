<?php

namespace App\Exports;

use App\Traits\ReportTraitArmobile;
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
dd($this->request);
        $groupedEntries = $this->report_armobile($this->request);
        $lastElement = end($groupedEntries);
        dd($groupedEntries);
        // dd($lastElement);
        $this->month = $lastElement;
        dd($groupedEntries);

        unset($groupedEntries['mounth']);
    }
}
