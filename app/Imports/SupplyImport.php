<?php

namespace App\Imports;

use App\Models\category_supply;
use App\Models\supply;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SupplyImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $category = category_supply::where('name_category', $row['categoria'])->first();
        return new supply([
            'name_supply' => $row['nombre'],
            'unit_meassurement' => $row['unidad_de_medida'],
            'quantity' => $row['cantidad'],
            'critical_quantity' => $row['cantidad_critica'],
            'id_category_supplies' => $category->id,

        ]);
    }
}
