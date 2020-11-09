<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class SongsExport implements FromArray
{
    protected $canciones;

    public function __construct(array $canciones)
    {
        $this->canciones = $canciones;
    }

    public function array(): array
    {
        return $this->canciones;
    }
}
