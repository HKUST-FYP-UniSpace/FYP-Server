<?php

namespace App;

use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\User;
use App\Owner;
use App\Tenant;
use App\Profile;
use App\House;
use App\Trade;
use App\Blog;

class Export implements FromArray, ShouldAutoSize, WithColumnFormatting, WithEvents
{
    public function __construct()
    {
      $this->users = User::get()->count();
      $this->owners = Owner::get()->count();
      $this->tenants = Tenant::get()->count();
      $this->houses = House::get()->count();
      $this->trades = Trade::get()->count();
      $this->blogs = Blog::get()->count();

      $this->males = Profile::select('gender')
                  ->join('tenants','profiles.user_id','=','tenants.user_id')
                  ->where(['gender' => 'M'])
                  ->get()
                  ->count();

      if($this->tenants == 0) {
        $this->males_percent = 0;
      } 
      else {
        $this->males_percent = number_format($this->males/$this->tenants  * 100, 1);
      }

      $this->females = Profile::select('gender')
                  ->join('tenants','profiles.user_id','=','tenants.user_id')
                  ->where(['gender' => 'F'])
                  ->get()
                  ->count();

      if($this->tenants == 0) {
        $this->females_percent = 0;
      }
      else {
        $this->females_percent = number_format($this->females/$this->tenants  * 100, 1);
      }
    }


    public function array(): array
    {
      $timezone  = 8;

        return [
            ['Statistics of Application'],
            ['updated at '.date("Y-m-d H:i:s", time() + 3600*($timezone+date("I")))],
            [''],
            ['All App Users :', $this->users],
            ['Number of Owners :', $this->owners],
            ['Number of Tenants :', $this->tenants],
            [''],
            ['Statistics of Posts'],
            ['Apartment Posts :', $this->houses],
            ['Trade Posts :', $this->trades],
            ['Blog Posts :', $this->blogs],
            [''],
            ['Tenant Statistics'],
            ['Male percentage (%) :', $this->males_percent],
            ['Female percentage (%):', $this->females_percent],

        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setCreator('UniSpace');
            },
            AfterSheet::class => function(AfterSheet $event) {
                $styleTitle= [
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                ];

                $styleAttribute = [
                    'font' => [
                        'size' => 14,
                    ],
                ];

                $styleData = [
                    'font' => [
                        'size' => 14,
                    ],
                    'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
                ];
                $event->sheet->getDelegate()->setTitle('Statistics')->getStyle('A1')->applyFromArray($styleTitle);
                $event->sheet->getDelegate()->getStyle('A4:A100')->applyFromArray($styleAttribute);
                $event->sheet->getDelegate()->getStyle('B4:B100')->applyFromArray($styleData);
                $event->sheet->getDelegate()->getStyle('A1'); // Set cell A1 as selected
            },
        ];
    }
}
