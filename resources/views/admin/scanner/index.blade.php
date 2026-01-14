@extends('admin.layouts.app')

@section('title', 'QR Scanner - Distribution Confirmation')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg mt-4">
                <div class="card-header bg-gradient-primary text-white py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <i class="fas fa-qrcode fa-2x"></i>
                            </div>
                            <div>
                                <h4 class="mb-0">QR Scanner</h4>
                                <p class="mb-0 small">Scan QR codes to confirm relief distribution</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.distribution-notifications.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Notifications
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <!-- Scan Method Tabs -->
                    <ul class="nav nav-tabs mb-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="camera-tab" data-toggle="tab" href="#camera" role="tab">
                                <i class="fas fa-camera mr-1"></i> Camera Scan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="manual-tab" data-toggle="tab" href="#manual" role="tab">
                                <i class="fas fa-keyboard mr-1"></i> Manual Entry
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Camera Scan Tab -->
                        <div class="tab-pane fade show active" id="camera" role="tabpanel">
                            <div class="text-center">
                                <div id="qr-reader" style="width: 100%; max-width: 500px; margin: 0 auto;"></div>
                                <div id="qr-reader-results" class="mt-3"></div>
                                <button id="start-scan-btn" class="btn btn-primary btn-lg mt-3">
                                    <i class="fas fa-camera mr-2"></i> Start Camera
                                </button>
                                <button id="stop-scan-btn" class="btn btn-secondary btn-lg mt-3" style="display: none;">
                                    <i class="fas fa-stop mr-2"></i> Stop Camera
                                </button>
                            </div>
                        </div>

                        <!-- Manual Entry Tab -->
                        <div class="tab-pane fade" id="manual" role="tabpanel">
                            <form id="manual-verify-form">
                                <div class="form-group">
                                    <label for="qr_code" class="font-weight-bold">
                                        <i class="fas fa-barcode mr-1"></i> Enter Claim Code
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="qr_code" name="qr_code" 
                                           placeholder="e.g., DIST-XXXXXXXXXXXX" style="text-transform: uppercase;">
                                    <small class="form-text text-muted">Enter the claim code from the resident's email or QR code</small>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-search mr-2"></i> Verify Code
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Verification Result -->
                    <div id="verification-result" class="mt-4" style="display: none;">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Recent Confirmations -->
            <div class="card shadow border-0 rounded-lg mt-4">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-history mr-2"></i> Recent Confirmations Today
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Resident</th>
                                    <th>Distribution</th>
                                    <th>Confirmed At</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="recent-confirmations">
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0">No confirmations yet today</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Sound -->
<audio id="success-sound" preload="auto">
    <source src="data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YU..." type="audio/wav">
</audio>
@endsection

@push('styles')
<style>
    #qr-reader {
        border: 3px solid #4e73df;
        border-radius: 10px;
        overflow: hidden;
    }
    #qr-reader video {
        border-radius: 8px;
    }
    .verification-success {
        background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
        color: white;
        padding: 2rem;
        border-radius: 10px;
        animation: slideIn 0.3s ease;
    }
    .verification-error {
        background: linear-gradient(135deg, #e74a3b 0%, #c0392b 100%);
        color: white;
        padding: 2rem;
        border-radius: 10px;
        animation: slideIn 0.3s ease;
    }
    .verification-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
        color: #1f2d3d;
        padding: 2rem;
        border-radius: 10px;
        animation: slideIn 0.3s ease;
    }
    @keyframes slideIn {
        from { 
            opacity: 0; 
            transform: translateY(-20px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    .resident-info {
        background: rgba(255,255,255,0.2);
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
    }
</style>
@endpush

@push('scripts')
<!-- html5-qrcode library -->
<script src="https://unpkg.com/html5-qrcode@2.3.4/html5-qrcode.min.js"></script>
<script>
    let html5QrcodeScanner = null;
    const verifyUrl = "{{ route('admin.scanner.verify') }}";
    const confirmUrl = "{{ route('admin.scanner.confirm') }}";
    const csrfToken = "{{ csrf_token() }}";

    // Start camera scanning
    document.getElementById('start-scan-btn').addEventListener('click', function() {
        this.style.display = 'none';
        document.getElementById('stop-scan-btn').style.display = 'inline-block';
        
        html5QrcodeScanner = new Html5Qrcode("qr-reader");
        html5QrcodeScanner.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: { width: 250, height: 250 } },
            onScanSuccess,
            onScanFailure
        ).catch((err) => {
            console.error(err);
            alert('Error starting camera: ' + err);
            document.getElementById('start-scan-btn').style.display = 'inline-block';
            document.getElementById('stop-scan-btn').style.display = 'none';
        });
    });

    // Stop camera scanning
    document.getElementById('stop-scan-btn').addEventListener('click', function() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
                document.getElementById('start-scan-btn').style.display = 'inline-block';
                document.getElementById('stop-scan-btn').style.display = 'none';
            });
        }
    });

    // Handle successful QR scan
    function onScanSuccess(decodedText, decodedResult) {
        // Stop scanning
        if (html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
                document.getElementById('start-scan-btn').style.display = 'inline-block';
                document.getElementById('stop-scan-btn').style.display = 'none';
            });
        }
        
        // Verify the code
        verifyCode(decodedText);
    }

    function onScanFailure(error) {
        // Ignore scan failures (common when no QR code is in view)
    }

    // Manual entry form
    document.getElementById('manual-verify-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const code = document.getElementById('qr_code').value.trim().toUpperCase();
        if (code) {
            verifyCode(code);
        }
    });

    // Verify a code
    function verifyCode(code) {
        const resultDiv = document.getElementById('verification-result');
        resultDiv.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin fa-3x"></i><p class="mt-2">Verifying...</p></div>';
        resultDiv.style.display = 'block';

        fetch(verifyUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ qr_code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showVerificationSuccess(data.data);
            } else if (data.already_confirmed) {
                showAlreadyConfirmed(data.data);
            } else {
                showVerificationError(data.message);
            }
        })
        .catch(error => {
            showVerificationError('Error verifying code. Please try again.');
            console.error(error);
        });
    }

    function showVerificationSuccess(data) {
        const resultDiv = document.getElementById('verification-result');
        resultDiv.innerHTML = `
            <div class="verification-success">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-check-circle fa-3x mr-3"></i>
                    <div>
                        <h4 class="mb-0">QR Code Verified!</h4>
                        <p class="mb-0">Ready to confirm distribution</p>
                    </div>
                </div>
                <div class="resident-info">
                    <h5><i class="fas fa-user mr-2"></i>${data.resident_name}</h5>
                    <p class="mb-1"><i class="fas fa-map-marker-alt mr-2"></i>${data.resident_address}</p>
                    <p class="mb-1"><i class="fas fa-phone mr-2"></i>${data.resident_phone}</p>
                    <p class="mb-0"><i class="fas fa-users mr-2"></i>Family Members: ${data.family_members}</p>
                </div>
                <div class="mt-3">
                    <p class="mb-2"><strong>Distribution:</strong> ${data.distribution_title}</p>
                    <p class="mb-0"><strong>Location:</strong> ${data.distribution_location}</p>
                </div>
                <div class="mt-4">
                    <button class="btn btn-light btn-lg btn-block" onclick="confirmDistribution(${data.confirmation_id})">
                        <i class="fas fa-hand-holding-heart mr-2"></i> Confirm Relief Received
                    </button>
                </div>
            </div>
        `;
    }

    function showAlreadyConfirmed(data) {
        const resultDiv = document.getElementById('verification-result');
        resultDiv.innerHTML = `
            <div class="verification-warning">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-exclamation-triangle fa-3x mr-3"></i>
                    <div>
                        <h4 class="mb-0">Already Claimed!</h4>
                        <p class="mb-0">This relief package has already been distributed</p>
                    </div>
                </div>
                <div class="resident-info">
                    <p class="mb-1"><strong>Resident:</strong> ${data.resident_name}</p>
                    <p class="mb-1"><strong>Confirmed At:</strong> ${data.confirmed_at}</p>
                    <p class="mb-0"><strong>Confirmed By:</strong> ${data.confirmed_by}</p>
                </div>
                <div class="mt-4">
                    <button class="btn btn-dark btn-lg btn-block" onclick="resetScanner()">
                        <i class="fas fa-redo mr-2"></i> Scan Another Code
                    </button>
                </div>
            </div>
        `;
    }

    function showVerificationError(message) {
        const resultDiv = document.getElementById('verification-result');
        resultDiv.innerHTML = `
            <div class="verification-error">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-times-circle fa-3x mr-3"></i>
                    <div>
                        <h4 class="mb-0">Invalid Code</h4>
                        <p class="mb-0">${message}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-light btn-lg btn-block" onclick="resetScanner()">
                        <i class="fas fa-redo mr-2"></i> Try Again
                    </button>
                </div>
            </div>
        `;
    }

    function confirmDistribution(confirmationId) {
        const resultDiv = document.getElementById('verification-result');
        
        fetch(confirmUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ confirmation_id: confirmationId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                resultDiv.innerHTML = `
                    <div class="verification-success">
                        <div class="text-center mb-3">
                            <i class="fas fa-check-circle fa-5x mb-3"></i>
                            <h3>Distribution Confirmed!</h3>
                            <p class="mb-0">${data.data.resident_name} has received their relief package</p>
                            <p class="text-white-50">${data.data.confirmed_at}</p>
                        </div>
                        <button class="btn btn-light btn-lg btn-block" onclick="resetScanner()">
                            <i class="fas fa-qrcode mr-2"></i> Scan Next Code
                        </button>
                    </div>
                `;
                // Play success sound (optional)
                try {
                    document.getElementById('success-sound').play();
                } catch(e) {}
            } else {
                showVerificationError(data.message);
            }
        })
        .catch(error => {
            showVerificationError('Error confirming distribution. Please try again.');
            console.error(error);
        });
    }

    function resetScanner() {
        const resultDiv = document.getElementById('verification-result');
        resultDiv.style.display = 'none';
        resultDiv.innerHTML = '';
        document.getElementById('qr_code').value = '';
    }
</script>
@endpush
