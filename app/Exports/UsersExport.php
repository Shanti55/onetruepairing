<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromView, ShouldAutoSize, WithStyles
{
    use Exportable;

    public $query;

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => [
                'font' => ['bold' => true],
                'b',
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => array('argb' => 'FFFFFF00')
                )
            ],
            'D' => ['alignment' => ['wrapText' => true]],

        ];
    }


    public function withQuery($params)
    {
        $this->query = User::where('role','user');
        $this->query = $this->query->with('userprofile');
        return $this;
    }

    public function view(): View
    {
        return view('admin-panel.exports.users',[
            'users' => $this->query->get()
        ]);
    }

}
