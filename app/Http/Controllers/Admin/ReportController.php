<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\Donation;
use App\Models\ReliefRequest;
use App\Models\Distribution;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        \Log::info('Report index method called');
        $defaultEndDate = now()->format('Y-m-d');
        $defaultStartDate = now()->subMonth()->format('Y-m-d');
        
        // Get report statistics
        $totalReports = 0;
        $monthlyReports = 0;
        $pendingReports = 0;
        $todayReports = 0;
        
        try {
            // You would implement actual statistics gathering here
            // For now, we'll set some placeholder values
            $totalReports = 5;
            $monthlyReports = 2;
            $todayReports = 1;
        } catch (\Exception $e) {
            \Log::error('Error getting report statistics: ' . $e->getMessage());
        }
        
        return view('admin.reports.index', [
            'defaultStartDate' => $defaultStartDate,
            'defaultEndDate' => $defaultEndDate,
            'totalReports' => $totalReports,
            'monthlyReports' => $monthlyReports,
            'pendingReports' => $pendingReports,
            'todayReports' => $todayReports,
        ]);
    }

    public function generate(Request $request)
    {
        // Log the request method for debugging
        \Log::info('Report generate request method: ' . $request->method());
        \Log::info('Report generate request data: ' . json_encode($request->all()));
        
        try {
            // Simplified validation for testing
            $validated = $request->validate([
                'report_type' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'format' => 'required',
            ]);
            
            \Log::info('Report validation passed');
            \Log::info('Validated data: ' . json_encode($validated));

            $startDate = Carbon::parse($validated['start_date'])->startOfDay();
            $endDate = Carbon::parse($validated['end_date'])->endOfDay();
            
            \Log::info('Date range: ' . $startDate . ' to ' . $endDate);

            $data = $this->getReportData($validated['report_type'], $startDate, $endDate);
            $data['start_date'] = $startDate->format('M d, Y');
            $data['end_date'] = $endDate->format('M d, Y');
            $data['generated_at'] = now()->format('M d, Y h:i A');
            $data['report_type'] = ucfirst(str_replace('_', ' ', $validated['report_type']));
            $data['report_title'] = ucfirst(str_replace('_', ' ', $validated['report_type'])) . ' Report';
            
            \Log::info('Report data prepared: ' . json_encode(array_keys($data)));
            \Log::info('Report data count: ' . count($data));

            // Add statistics to the data
            $data['totalReports'] = 5;
            $data['monthlyReports'] = 2;
            $data['pendingReports'] = 0;
            $data['todayReports'] = 1;

            // Handle different export formats
            if ($validated['format'] === 'csv') {
                // Generate CSV file
                $filename = $this->exportToCsv($validated['report_type'], $data);
                
                // Return download response
                return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend(true);
            } elseif ($validated['format'] === 'pdf') {
                // Generate PDF file
                $pdf = \PDF::loadView('admin.reports.pdf.' . $validated['report_type'], $data);
                $filename = 'report_' . $validated['report_type'] . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';
                
                return $pdf->download($filename);
            } elseif ($validated['format'] === 'xml') {
                // Generate XML file
                $filename = $this->exportToXml($validated['report_type'], $data);
                
                // Return download response
                return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend(true);
            }

            // For testing, let's return a simple response to confirm it's working
            if ($request->has('test_response')) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Report generated successfully',
                    'data_keys' => array_keys($data),
                    'record_count' => isset($data['donations']) ? count($data['donations']) : 0
                ]);
            }

            // For now, we'll just return the view regardless of format
            // PDF and Excel functionality can be added later when proper packages are installed
            return view('admin.reports.index', array_merge($data, [
                'defaultStartDate' => $startDate->format('Y-m-d'),
                'defaultEndDate' => $endDate->format('Y-m-d'),
            ]));
        } catch (\Exception $e) {
            \Log::error('Report generation error: ' . $e->getMessage());
            \Log::error('Report generation trace: ' . $e->getTraceAsString());
            return back()->with('error', 'An error occurred while generating the report: ' . $e->getMessage());
        }
    }

    protected function getReportData($type, $startDate, $endDate)
    {
        \Log::info("Getting report data for type: $type");
        
        switch ($type) {
            case 'donations':
                \Log::info("Fetching donations data");
                $result = [
                    'donations' => Donation::with('donor')
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->orderBy('created_at', 'desc')
                        ->get(),
                    'total_amount' => Donation::whereBetween('created_at', [$startDate, $endDate])
                        ->sum('amount')
                ];
                \Log::info("Donations data fetched: " . count($result['donations']) . " records");
                return $result;
                
            case 'requests':
            case 'relief_requests':
                \Log::info("Fetching relief requests data");
                $result = [
                    'requests' => ReliefRequest::with('resident')
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->orderBy('created_at', 'desc')
                        ->get(),
                    'status_counts' => ReliefRequest::selectRaw('status, count(*) as count')
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->groupBy('status')
                        ->pluck('count', 'status')
                ];
                \Log::info("Relief requests data fetched: " . count($result['requests']) . " records");
                return $result;
                
            case 'distributions':
                \Log::info("Fetching distributions data");
                $result = [
                    'distributions' => Distribution::with(['reliefRequest', 'distributedBy'])
                        ->whereBetween('distribution_date', [$startDate, $endDate])
                        ->orderBy('distribution_date', 'desc')
                        ->get(),
                    'status_counts' => Distribution::selectRaw('status, count(*) as count')
                        ->whereBetween('distribution_date', [$startDate, $endDate])
                        ->groupBy('status')
                        ->pluck('count', 'status')
                ];
                \Log::info("Distributions data fetched: " . count($result['distributions']) . " records");
                return $result;
                
            case 'donors':
                \Log::info("Fetching donors data");
                $result = [
                    'donors' => Donor::whereBetween('created_at', [$startDate, $endDate])
                        ->orderBy('created_at', 'desc')
                        ->get(),
                    'total' => Donor::whereBetween('created_at', [$startDate, $endDate])->count(),
                    'total_donations' => Donation::whereBetween('created_at', [$startDate, $endDate])
                        ->sum('amount')
                ];
                \Log::info("Donors data fetched: " . count($result['donors']) . " records");
                return $result;
                
            case 'inventory':
                \Log::info("Fetching inventory data");
                // For now, return empty data for inventory
                $result = [
                    'inventory' => [],
                    'total' => 0
                ];
                \Log::info("Inventory data fetched");
                return $result;
                
            case 'residents':
                \Log::info("Fetching residents data");
                // For now, return empty data for residents
                $result = [
                    'residents' => [],
                    'total' => 0
                ];
                \Log::info("Residents data fetched");
                return $result;
        }
        
        \Log::warning("Unknown report type: $type");
        return [];
    }
    
    protected function exportToCsv($type, $data)
    {
        // Create a temporary file
        $filename = 'report_' . $type . '_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $filepath = storage_path('app/public/' . $filename);
        
        // Ensure the directory exists
        if (!file_exists(storage_path('app/public'))) {
            mkdir(storage_path('app/public'), 0755, true);
        }
        
        $file = fopen($filepath, 'w');
        
        // Add BOM for UTF-8 support in Excel
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Write headers and data based on report type
        switch ($type) {
            case 'donations':
                if (isset($data['donations']) && count($data['donations']) > 0) {
                    // Headers
                    fputcsv($file, ['ID', 'Donor', 'Amount', 'Date', 'Status']);
                    
                    // Data
                    foreach ($data['donations'] as $donation) {
                        fputcsv($file, [
                            $donation->id,
                            $donation->donor->name ?? 'N/A',
                            $donation->amount,
                            $donation->created_at->format('Y-m-d H:i:s'),
                            $donation->status
                        ]);
                    }
                }
                break;
                
            case 'distributions':
                if (isset($data['distributions']) && count($data['distributions']) > 0) {
                    // Headers
                    fputcsv($file, ['ID', 'Request ID', 'Distributed By', 'Distribution Date', 'Status']);
                    
                    // Data
                    foreach ($data['distributions'] as $distribution) {
                        fputcsv($file, [
                            $distribution->id,
                            $distribution->relief_request_id ?? 'N/A',
                            $distribution->distributedBy->name ?? 'N/A',
                            $distribution->distribution_date->format('Y-m-d'),
                            $distribution->status
                        ]);
                    }
                }
                break;
                
            case 'relief_requests':
            case 'requests':
                if (isset($data['requests']) && count($data['requests']) > 0) {
                    // Headers
                    fputcsv($file, ['ID', 'Resident', 'Family Members', 'Date', 'Status']);
                    
                    // Data
                    foreach ($data['requests'] as $request) {
                        fputcsv($file, [
                            $request->id,
                            $request->resident->name ?? 'N/A',
                            $request->family_members,
                            $request->created_at->format('Y-m-d H:i:s'),
                            $request->status
                        ]);
                    }
                }
                break;
                
            case 'donors':
                if (isset($data['donors']) && count($data['donors']) > 0) {
                    // Headers
                    fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Created At']);
                    
                    // Data
                    foreach ($data['donors'] as $donor) {
                        fputcsv($file, [
                            $donor->id,
                            $donor->name,
                            $donor->email ?? 'N/A',
                            $donor->phone ?? 'N/A',
                            $donor->created_at->format('Y-m-d H:i:s')
                        ]);
                    }
                }
                break;
        }
        
        fclose($file);
        
        // Return the filename for download
        return $filename;
    }
    
    protected function exportToXml($type, $data)
    {
        // Create a temporary file
        $filename = 'report_' . $type . '_' . now()->format('Y-m-d_H-i-s') . '.xml';
        $filepath = storage_path('app/public/' . $filename);
        
        // Ensure the directory exists
        if (!file_exists(storage_path('app/public'))) {
            mkdir(storage_path('app/public'), 0755, true);
        }
        
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><report></report>');
        $xml->addChild('type', $type);
        $xml->addChild('generated_at', now()->format('Y-m-d H:i:s'));
        
        $items = $xml->addChild('items');
        
        // Add data based on report type
        switch ($type) {
            case 'donations':
                if (isset($data['donations'])) {
                    foreach ($data['donations'] as $donation) {
                        $item = $items->addChild('donation');
                        $item->addChild('id', $donation->id);
                        $item->addChild('donor', htmlspecialchars($donation->donor->name ?? 'N/A'));
                        $item->addChild('amount', $donation->amount);
                        $item->addChild('date', $donation->created_at->format('Y-m-d H:i:s'));
                        $item->addChild('status', $donation->status);
                    }
                }
                break;
                
            case 'distributions':
                if (isset($data['distributions'])) {
                    foreach ($data['distributions'] as $distribution) {
                        $item = $items->addChild('distribution');
                        $item->addChild('id', $distribution->id);
                        $item->addChild('request_id', $distribution->relief_request_id ?? 'N/A');
                        $item->addChild('distributed_by', htmlspecialchars($distribution->distributedBy->name ?? 'N/A'));
                        $item->addChild('date', $distribution->distribution_date->format('Y-m-d'));
                        $item->addChild('status', $distribution->status);
                    }
                }
                break;
                
            case 'relief_requests':
            case 'requests':
                if (isset($data['requests'])) {
                    foreach ($data['requests'] as $request) {
                        $item = $items->addChild('request');
                        $item->addChild('id', $request->id);
                        $item->addChild('resident', htmlspecialchars($request->resident->name ?? 'N/A'));
                        $item->addChild('family_members', $request->family_members);
                        $item->addChild('date', $request->created_at->format('Y-m-d H:i:s'));
                        $item->addChild('status', $request->status);
                    }
                }
                break;
                
            case 'donors':
                if (isset($data['donors'])) {
                    foreach ($data['donors'] as $donor) {
                        $item = $items->addChild('donor');
                        $item->addChild('id', $donor->id);
                        $item->addChild('name', htmlspecialchars($donor->name));
                        $item->addChild('email', htmlspecialchars($donor->email ?? 'N/A'));
                        $item->addChild('phone', htmlspecialchars($donor->phone ?? 'N/A'));
                        $item->addChild('created_at', $donor->created_at->format('Y-m-d H:i:s'));
                    }
                }
                break;
        }
        
        // Save XML
        $xml->asXML($filepath);
        
        // Return the filename for download
        return $filename;
    }
    
    protected function exportToExcel($type, $data)
    {
        // This would use Laravel Excel package to generate Excel files
        // Implementation depends on the Excel package you're using
        // For now, we'll just return a response indicating this feature is not implemented
        return back()->with('error', 'Excel export is not yet implemented.');
    }
}