<?php

namespace App\Imports;

use App\Models\InvoiceRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InvoiceImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $article) {
            InvoiceRow::create([
                'invoice_section_id' => $article['invoice_section_id'],
                'designation' => $article['designation'],
                'reference'  => $article['reference'],
                'quantite'   => $article['quantite'],
                'prix'      => $article['prix'],
            ]);
        }
    }

    public function startCell(): string
    {
        return 'A2';
    }
}
