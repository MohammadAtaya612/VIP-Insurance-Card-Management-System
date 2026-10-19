<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class RecipientsImport implements ToCollection, WithHeadingRow
{
    private array $rows = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $name = $row['name'] ?? $row['الاسم'] ?? $row['اسم'] ?? '';
            $phone = $row['phone'] ?? $row['الهاتف'] ?? $row['رقم_الهاتف'] ?? '';

            if (empty($name) || empty($phone)) {
                continue;
            }

            $this->rows[] = [
                'name' => trim((string) $name),
                'phone' => trim((string) $phone),
            ];
        }
    }

    public function getRows(): array
    {
        return $this->rows;
    }
}
