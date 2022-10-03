<?php

namespace App\Exports;

use App\Models\couries;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class CouriersExport implements FromCollection,WithHeadings,ShouldAutoSize,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $bid="";
    public function __construct($billid)
    {
        // $this->middleware('auth');
        $this->bid=$billid;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true ,'color' => ['argb'=>'FFFF0000']]],
            // 1 => ['font' => ['color'=>'#FF0000']],
            // 1 => ['fill' => ['color'=>'FFFF0000']],

            // // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function headings(): array
    {
        return [
            'SI.NO',
            'ID',
            'Date',
            'Amount',
            'From',
            'To',
        ];
    }

    public function collection()
    {
        return couries::select('id', 'cid', 'cdate','amount','cfrom','cto')
        ->where('billid',$this->bid)
        ->get();
    }
}
