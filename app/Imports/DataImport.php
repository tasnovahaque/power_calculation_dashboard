<?php

namespace App\Imports;

use App\Models\Data;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Data([
            'device_id'   => $row['device_id'],
            'record_time' => $row['record_time'],
            'energy'      => $row['energy'],
            'voltage'     => '220',
            'current'     => number_format($row['energy'] / 220, 2),
        ]);
    }
}
