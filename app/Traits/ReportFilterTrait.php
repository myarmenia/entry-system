<?php
namespace App\Traits;

trait ReportFilterTrait{
    // abstract function model();

    public function scopeFilter($builder, $filters = [])
  {


            if(!$filters) {
                return $builder;
        }
        dd($filters);

        $filterFields = isset($this->filterFields) ? $this->filterFields : false;
        // dd($filterFields);
        foreach($filterFields  as $key=>$value){
            if($value=="date"){
                foreach($filters['attendance_sheet'] as $at){
                    dd($at);
                }


            }

        }

        // return $query->whereHas('people', function ($q) {
        //     $q->where('client_id', Auth::user()->client_id);
        // });
  }

}
