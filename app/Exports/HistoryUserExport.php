<?php

namespace App\Exports;

use App\Models\UserActivityLog;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoryUserExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $query = UserActivityLog::with('user');

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get()->map(function ($log) {
            return [
                'ID' => $log->id,
                'User' => $log->user ? $log->user->nama : 'Guest',
                'Model' => $log->model,
                'Details' => $log->details,
                'IP Address' => $log->ip_address,
                'Timestamp' => $log->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'User',
            'Model',
            'Details',
            'IP Address',
            'Timestamp',
        ];
    }
}
