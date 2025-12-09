<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping 
{
    private $attendances;

    public function __construct(Collection $attendances)
    {
        $this->attendances = $attendances;
    }

    /**
     * The headings() function in PHP returns an array of headings for a table related to attendance
     * records.
     * 
     * @return array An array of headings is being returned. The headings include 'Día', 'Fecha', 'Tipo
     * asistencia', 'Hora de entrada', and 'Hora de Salida'.
     */
    public function headings(): array
    {
        return [
            'Día', 
            'Fecha', 
            'Tipo asistencia', 
            'Hora de entrada', 
            'Hora de Salida'
        ];
    }

    public function map($attendance): array
    {
        return [
            /** Día */
            $attendance->userSchedule?->day?->name ?? '--',
            /** Fecha */
            optional($attendance->created_at)->format('Y-m-d'),
            /** Tipo asistencia: (asistio, no asistio, etc)*/
            $attendance->attendanceStatus?->name ?? '---',
            /** Hora de entrada */
            $attendance->userSchedule?->entry_time ? substr($attendance->userSchedule->entry_time, 0, 5): '---',
            /** Hora de salida */
            $attendance->userSchedule?->departure_time ? substr($attendance->userSchedule->departure_time, 0, 5): '---',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        return $this->attendances;
    }
}