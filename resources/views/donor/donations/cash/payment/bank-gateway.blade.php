<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Banking - Secure Transfer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        .bank-blue { background: linear-gradient(135deg, #1E40AF 0%, #1E3A8A 100%); }
        .pin-input {
            width: 50px;
            height: 50px;
            font-size: 24px;
            text-align: center;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
        }
        .pin-input:focus {
            outline: none;
            border-color: #1E40AF;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }
        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .slide-up {
            animation: slideUp 0.3s ease-out;
        }
        @keyframes checkmark {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        .checkmark-animate {
            animation: checkmark 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Bank Header -->
    <div class="bank-blue text-white px-4 py-4 shadow-lg">
        <div class="max-w-md mx-auto flex items-center justify-between">
            <button onclick="goBack()" class="text-white hover:bg-white/20 rounded-full p-2 transition">
                <i class="fas fa-arrow-left text-xl"></i>
            </button>
            <div class="flex items-center space-x-2">
                <i class="fas fa-university text-2xl"></i>
                <span class="text-xl font-bold">Online Banking</span>
            </div>
            <div class="w-10"></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-md mx-auto">
        <!-- Step 1: Transfer Details -->
        <div id="step1" class="slide-up">
            <div class="bg-white shadow-sm p-6 mb-4">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exchange-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Fund Transfer</h2>
                    <p class="text-gray-500 text-sm mt-1">Review transfer details</p>
                </div>

                <div class="bg-blue-50 rounded-xl p-6 mb-6">
                    <div class="text-center mb-4">
                        <p class="text-sm text-gray-600 mb-2">Transfer Amount</p>
                        <p class="text-4xl font-bold text-blue-600">₱{{ number_format($amount, 2) }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-2">FROM ACCOUNT</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-gray-800">Savings Account</p>
                                <p class="text-sm text-gray-600 font-mono">XXXX-XXXX-1234</p>
                            </div>
                            <i class="fas fa-wallet text-blue-600 text-xl"></i>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <div class="bg-blue-100 rounded-full p-2">
                            <i class="fas fa-arrow-down text-blue-600"></i>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-2">TO ACCOUNT</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-gray-800">Barangay Cubacub</p>
                                <p class="text-sm text-gray-600 font-mono">XXXX-XXXX-5678</p>
                                <p class="text-xs text-gray-500 mt-1">Relief & Donation Fund</p>
                            </div>
                            <i class="fas fa-building text-blue-600 text-xl"></i>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Transfer Fee</span>
                            <span class="font-medium text-gray-800">₱0.00</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg">
                            <span class="text-gray-800">Total Amount</span>
                            <span class="text-blue-600">₱{{ number_format($amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 mx-4">
                <div class="flex">
                    <i class="fas fa-shield-alt text-yellow-600 mt-1"></i>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-800">
                            <strong>Secure Transaction:</strong> This transfer is protected by bank-level security.
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-4 pb-6">
                <button onclick="showPinEntry()" class="w-full bank-blue text-white py-4 rounded-lg font-semibold text-lg shadow-lg hover:shadow-xl transition">
                    Proceed to Transfer
                </button>
            </div>
        </div>

        <!-- Step 2: OTP/PIN Entry -->
        <div id="step2" class="hidden">
            <div class="bg-white shadow-sm p-6 mb-4">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-key text-blue-600 text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Enter OTP</h2>
                    <p class="text-gray-500">Enter the 6-digit code sent to your registered mobile number</p>
                    <p class="text-sm text-gray-400 mt-2">XXXX-XXX-1234</p>
                </div>

                <div class="flex justify-center space-x-3 mb-8">
                    <input type="text" maxlength="1" class="pin-input" id="otp1" oninput="moveFocus(this, 'otp2')" onkeydown="handleBackspace(event, this, null)">
                    <input type="text" maxlength="1" class="pin-input" id="otp2" oninput="moveFocus(this, 'otp3')" onkeydown="handleBackspace(event, this, 'otp1')">
                    <input type="text" maxlength="1" class="pin-input" id="otp3" oninput="moveFocus(this, 'otp4')" onkeydown="handleBackspace(event, this, 'otp2')">
                    <input type="text" maxlength="1" class="pin-input" id="otp4" oninput="moveFocus(this, 'otp5')" onkeydown="handleBackspace(event, this, 'otp3')">
                    <input type="text" maxlength="1" class="pin-input" id="otp5" oninput="moveFocus(this, 'otp6')" onkeydown="handleBackspace(event, this, 'otp4')">
                    <input type="text" maxlength="1" class="pin-input" id="otp6" oninput="validateOtp()" onkeydown="handleBackspace(event, this, 'otp5')">
                </div>

                <div id="otpError" class="hidden text-center text-red-600 mb-4">
                    <i class="fas fa-exclamation-circle"></i> Invalid OTP. Please try again.
                </div>

                <div class="text-center mb-6">
                    <p class="text-sm text-gray-600 mb-2">Didn't receive the code?</p>
                    <button onclick="resendOtp()" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                        Resend OTP
                    </button>
                </div>

                <div class="text-center">
                    <button onclick="showStep1()" class="text-blue-600 hover:text-blue-700 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </button>
                </div>
            </div>

            <div class="px-4">
                <div class="bg-gray-100 rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-600">
                        <i class="fas fa-lock mr-1"></i> 
                        Protected by 256-bit SSL encryption
                    </p>
                </div>
            </div>
        </div>

        <!-- Step 3: Processing -->
        <div id="step3" class="hidden">
            <div class="bg-white shadow-sm p-8 text-center">
                <div class="mb-6">
                    <div class="inline-block">
                        <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-blue-600"></div>
                    </div>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Processing Transfer</h2>
                <p class="text-gray-500">Please wait while we process your transaction...</p>
                <div class="mt-6 space-y-2">
                    <div class="flex items-center justify-center text-sm text-gray-600">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        <span>Verifying account details</span>
                    </div>
                    <div class="flex items-center justify-center text-sm text-gray-600">
                        <i class="fas fa-spinner fa-spin text-blue-600 mr-2"></i>
                        <span>Processing transfer...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Success -->
        <div id="step4" class="hidden">
            <div class="bg-white shadow-sm p-8">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center checkmark-animate">
                        <i class="fas fa-check text-green-600 text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Transfer Successful!</h2>
                    <p class="text-gray-500">Your donation has been transferred</p>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 mb-6">
                    <div class="space-y-4">
                        <div class="text-center pb-4 border-b border-blue-200">
                            <p class="text-sm text-gray-600 mb-1">Transaction Reference Number</p>
                            <p class="text-lg font-mono font-bold text-blue-600" id="referenceNumber"></p>
                        </div>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date & Time</span>
                                <span class="font-medium text-gray-800" id="transactionDate"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">From Account</span>
                                <span class="font-mono text-gray-800">XXXX-1234</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">To Account</span>
                                <span class="font-mono text-gray-800">XXXX-5678</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Beneficiary</span>
                                <span class="font-medium text-gray-800">Barangay Cubacub</span>
                            </div>
                            <div class="flex justify-between pt-3 border-t border-blue-200">
                                <span class="text-gray-600 font-semibold">Amount Transferred</span>
                                <span class="font-bold text-xl text-blue-600">₱{{ number_format($amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="completeForm" action="{{ route('donor.donations.cash.process', ['method' => 'bank']) }}" method="POST">
                    @csrf
                    <input type="hidden" name="amount" value="{{ $amount }}">
                    <input type="hidden" name="reference_number" id="hiddenReferenceNumber">
                    <input type="hidden" name="payment_completed" value="1">
                    
                    <button type="submit" class="w-full bank-blue text-white py-4 rounded-lg font-semibold text-lg shadow-lg hover:shadow-xl transition mb-3">
                        Complete Donation
                    </button>
                </form>

                <button onclick="downloadReceipt()" class="w-full border-2 border-blue-600 text-blue-600 py-3 rounded-lg font-semibold hover:bg-blue-50 transition mb-3">
                    <i class="fas fa-download mr-2"></i>Download Receipt
                </button>

                <button onclick="emailReceipt()" class="w-full border-2 border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                    <i class="fas fa-envelope mr-2"></i>Email Receipt
                </button>
            </div>
        </div>
    </div>

    <script>
        // Generate unique reference number
        function generateReferenceNumber() {
            const timestamp = Date.now();
            const random = Math.floor(Math.random() * 1000000).toString().padStart(6, '0');
            return 'BNK' + timestamp.toString().slice(-10) + random;
        }

        function showPinEntry() {
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
            document.getElementById('step2').classList.add('slide-up');
            document.getElementById('otp1').focus();
        }

        function showStep1() {
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step1').classList.remove('hidden');
            // Clear OTP inputs
            ['otp1', 'otp2', 'otp3', 'otp4', 'otp5', 'otp6'].forEach(id => {
                document.getElementById(id).value = '';
            });
            document.getElementById('otpError').classList.add('hidden');
        }

        function moveFocus(current, nextId) {
            if (current.value.length === 1 && nextId) {
                document.getElementById(nextId).focus();
            }
        }

        function handleBackspace(event, current, prevId) {
            if (event.key === 'Backspace' && current.value === '' && prevId) {
                event.preventDefault();
                document.getElementById(prevId).focus();
            }
        }

        function validateOtp() {
            const otps = ['otp1', 'otp2', 'otp3', 'otp4', 'otp5', 'otp6'];
            const allFilled = otps.every(id => document.getElementById(id).value !== '');

            if (allFilled) {
                // Simulate OTP validation (accept any 6 digits)
                setTimeout(() => {
                    processTransfer();
                }, 500);
            }
        }

        function resendOtp() {
            alert('A new OTP has been sent to your registered mobile number.');
        }

        function processTransfer() {
            // Show processing screen
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step3').classList.remove('hidden');
            document.getElementById('step3').classList.add('slide-up');

            // Simulate processing delay
            setTimeout(() => {
                showSuccess();
            }, 3000);
        }

        function showSuccess() {
            const referenceNumber = generateReferenceNumber();
            const now = new Date();
            const dateStr = now.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric', 
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            document.getElementById('referenceNumber').textContent = referenceNumber;
            document.getElementById('transactionDate').textContent = dateStr;
            document.getElementById('hiddenReferenceNumber').value = referenceNumber;

            document.getElementById('step3').classList.add('hidden');
            document.getElementById('step4').classList.remove('hidden');
            document.getElementById('step4').classList.add('slide-up');
        }

        function downloadReceipt() {
            alert('Receipt download feature will be available soon!');
        }

        function emailReceipt() {
            alert('Receipt will be sent to your registered email address.');
        }

        function goBack() {
            if (confirm('Are you sure you want to cancel this transfer?')) {
                window.location.href = '{{ route('donor.donations.cash.payment', ['method' => 'bank']) }}';
            }
        }

        // Prevent accidental page refresh
        window.addEventListener('beforeunload', function (e) {
            const step4 = document.getElementById('step4');
            if (!step4.classList.contains('hidden')) {
                return; // Allow navigation if payment is complete
            }
            e.preventDefault();
            e.returnValue = '';
        });
    </script>
</body>
</html>
