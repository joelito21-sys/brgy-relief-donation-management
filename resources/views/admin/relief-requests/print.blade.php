<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Slip - {{ $reliefRequest->request_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            color: #333;
            line-height: 1.5;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .print-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #dee2e6;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .qr-code {
            max-width: 150px;
            margin: 0 auto 15px;
        }
        .claim-code {
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 2px;
            text-align: center;
            margin: 15px 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .details-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .details-table th, 
        .details-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        .details-table th {
            background-color: #f8f9fa;
            width: 30%;
        }
        .items-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .items-table th, 
        .items-table td {
            padding: 10px;
            border: 1px solid #dee2e6;
        }
        .items-table th {
            background-color: #f8f9fa;
            text-align: left;
        }
        .signature-area {
            margin-top: 50px;
            padding-top: 15px;
            border-top: 1px dashed #333;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
            font-size: 0.9em;
            text-align: center;
            color: #6c757d;
        }
        @media print {
            body {
                padding: 20px;
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                padding: 0;
            }
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: capitalize;
        }
        .status-pending { background-color: #ffc107; color: #000; }
        .status-approved { background-color: #28a745; color: #fff; }
        .status-rejected { background-color: #dc3545; color: #fff; }
        .status-ready { background-color: #17a2b8; color: #fff; }
        .status-claimed { background-color: #6f42c1; color: #fff; }
        .status-delivered { background-color: #20c997; color: #fff; }
    </style>
</head>
<body>
    <div class="print-container">
        <!-- Header with Logo and Title -->
        <div class="header">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            @else
                <h2>Flood Relief Management System</h2>
            @endif
            <h1 class="h3 mb-0">Relief Claim Slip</h1>
            <p class="text-muted">Keep this slip for your records</p>
        </div>

        <!-- QR Code and Claim Code -->
        <div class="row mb-4">
            <div class="col-md-6 text-center">
                @if($reliefRequest->qr_code_path && file_exists(public_path('storage/' . $reliefRequest->qr_code_path)))
                    <img src="{{ asset('storage/' . $reliefRequest->qr_code_path) }}" alt="QR Code" class="img-fluid qr-code">
                @else
                    <div class="text-center p-4 border rounded">
                        <i class="fas fa-qrcode fa-4x text-muted mb-3"></i>
                        <p class="mb-0">QR Code not available</p>
                    </div>
                @endif
                <div class="claim-code">
                    {{ $reliefRequest->claim_code }}
                </div>
                <div class="status-badge status-{{ str_replace('_', '-', $reliefRequest->status) }}">
                    {{ str_replace('_', ' ', ucfirst($reliefRequest->status)) }}
                </div>
            </div>
            <div class="col-md-6">
                <table class="details-table">
                    <tr>
                        <th>Request Number:</th>
                        <td>{{ $reliefRequest->request_number }}</td>
                    </tr>
                    <tr>
                        <th>Request Date:</th>
                        <td>{{ $reliefRequest->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Resident Name:</th>
                        <td>{{ $reliefRequest->full_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Contact Number:</th>
                        <td>{{ $reliefRequest->contact_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Email Address:</th>
                        <td>{{ $reliefRequest->email_address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Complete Address:</th>
                        <td>{{ $reliefRequest->complete_address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Household Size:</th>
                        <td>{{ $reliefRequest->household_size ?? $reliefRequest->family_members }} person(s)</td>
                    </tr>
                    <tr>
                        <th>Urgency Level:</th>
                        <td>
                            <span class="status-badge status-{{ $reliefRequest->urgency_level }}">
                                {{ ucfirst($reliefRequest->urgency_level ?? 'N/A') }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Delivery Method:</th>
                        <td>{{ ucfirst($reliefRequest->delivery_method) }}</td>
                    </tr>
                    @if($reliefRequest->delivery_method === 'pickup')
                        <tr>
                            <th>Pickup Location:</th>
                            <td>{{ $reliefRequest->pickup_location }}</td>
                        </tr>
                        @if($reliefRequest->scheduled_pickup_date)
                            <tr>
                                <th>Scheduled Pickup:</th>
                                <td>{{ $reliefRequest->scheduled_pickup_date->format('M d, Y h:i A') }}</td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <th>Delivery Address:</th>
                            <td>{{ $reliefRequest->delivery_address }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Requested Items -->
        <h5 class="mb-3">Requested Items</h5>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reliefRequest->items as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($item->image_path && file_exists(public_path('storage/' . $item->image_path)))
                                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" 
                                         style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px; border-radius: 4px;">
                                @endif
                                <span>{{ $item->name }}</span>
                            </div>
                        </td>
                        <td>{{ ucfirst($item->type) }}</td>
                        <td>{{ $item->pivot->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->pivot->notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-3">No items found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($reliefRequest->reason)
            <div class="mt-4">
                <h6>Reason for Request:</h6>
                <p class="mb-0">{{ $reliefRequest->reason }}</p>
            </div>
        @endif

        <!-- Signatures -->
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="signature-area">
                    <p class="mb-1">_________________________</p>
                    <p class="mb-0">Resident's Signature</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="signature-area">
                    <p class="mb-1">_________________________</p>
                    <p class="mb-0">Authorized Personnel</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer no-print">
            <p class="mb-1">Generated on {{ now()->format('M d, Y h:i A') }}</p>
            <p class="mb-0">Thank you for using our relief distribution system</p>
        </div>

        <!-- Print Button (only shows when not printing) -->
        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i> Print Claim Slip
            </button>
            <button onclick="window.close()" class="btn btn-outline-secondary ms-2">
                <i class="fas fa-times me-2"></i> Close
            </button>
        </div>
    </div>

    <script>
        // Auto-print when the page loads
        window.onload = function() {
            // Check if this is the first load (to prevent infinite loops with print dialog)
            if (!window.sessionStorage.getItem('printTriggered')) {
                window.sessionStorage.setItem('printTriggered', 'true');
                
                // Small delay to ensure everything is rendered
                setTimeout(function() {
                    window.print();
                    
                    // Reset the flag after printing is done (or canceled)
                    setTimeout(function() {
                        window.sessionStorage.removeItem('printTriggered');
                    }, 1000);
                }, 500);
            }
        };
        
        // Handle the afterprint event to close the window
        window.onafterprint = function() {
            // Only close if this is a popup window
            if (window.opener) {
                window.close();
            }
        };
    </script>
</body>
</html>
