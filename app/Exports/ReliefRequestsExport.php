<?php

namespace App\Exports;

use App\Models\ReliefRequest;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReliefRequestsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $query;
    protected $columns;

    public function __construct($query, $columns)
    {
        $this->query = $query;
        $this->columns = $columns;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        $headings = [];
        
        $availableColumns = [
            'request_number' => 'Request #',
            'user_name' => 'User',
            'user_email' => 'Email',
            'family_members' => 'Family Members',
            'status' => 'Status',
            'delivery_method' => 'Delivery Method',
            'pickup_location' => 'Pickup Location',
            'delivery_address' => 'Delivery Address',
            'scheduled_pickup_date' => 'Scheduled Pickup',
            'approved_at' => 'Approved At',
            'approved_by' => 'Approved By',
            'created_at' => 'Created At',
            'items_count' => 'Items Count',
        ];
        
        foreach ($this->columns as $column) {
            if (isset($availableColumns[$column])) {
                $headings[] = $availableColumns[$column];
            }
        }
        
        return $headings;
    }

    public function map($request): array
    {
        $row = [];
        
        foreach ($this->columns as $column) {
            switch ($column) {
                case 'user_name':
                    $row[] = $request->user ? $request->user->full_name : 'N/A';
                    break;
                case 'user_email':
                    $row[] = $request->user ? $request->user->email : 'N/A';
                    break;
                case 'approved_by':
                    $row[] = $request->approver ? $request->approver->name : 'N/A';
                    break;
                case 'status':
                    $row[] = ucfirst(str_replace('_', ' ', $request->status));
                    break;
                case 'delivery_method':
                    $row[] = ucfirst($request->delivery_method);
                    break;
                case 'created_at':
                case 'approved_at':
                case 'scheduled_pickup_date':
                    $row[] = $request->$column ? $request->$column->format('Y-m-d H:i:s') : 'N/A';
                    break;
                case 'items_count':
                    $row[] = $request->items_count ?? $request->items->count();
                    break;
                default:
                    $row[] = $request->$column ?? 'N/A';
            }
        }
        
        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'f3f4f6']
                ]
            ],
        ];
    }
}
