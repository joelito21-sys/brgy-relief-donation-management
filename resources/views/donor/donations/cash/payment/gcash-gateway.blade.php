<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GCash - Payment Gateway</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        .gcash-blue { background: linear-gradient(135deg, #007DFF 0%, #0062CC 100%); }
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
            border-color: #007DFF;
            box-shadow: 0 0 0 3px rgba(0, 125, 255, 0.1);
        }
        .pin-dot {
            width: 12px;
            height: 12px;
            background: #007DFF;
            border-radius: 50%;
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
    <!-- GCash Header -->
    <div class="gcash-blue text-white px-4 py-4 shadow-lg">
        <div class="max-w-md mx-auto flex items-center justify-between">
            <button onclick="goBack()" class="text-white hover:bg-white/20 rounded-full p-2 transition">
                <i class="fas fa-arrow-left text-xl"></i>
            </button>
            <div class="flex items-center space-x-2">
                <svg class="w-8 h-8" viewBox="0 0 40 40" fill="white">
                    <circle cx="20" cy="20" r="18" fill="white"/>
                    <path d="M20 8C13.4 8 8 13.4 8 20s5.4 12 12 12 12-5.4 12-12S26.6 8 20 8zm0 21c-5 0-9-4-9-9s4-9 9-9 9 4 9 9-4 9-9 9z" fill="#007DFF"/>
                    <path d="M20 12c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 14c-3.3 0-6-2.7-6-6s2.7-6 6-6 6 2.7 6 6-2.7 6-6 6z" fill="#007DFF"/>
                </svg>
                <span class="text-xl font-bold">GCash</span>
            </div>
            <div class="w-10"></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-md mx-auto">
        <!-- Step 1: Payment Details -->
        <div id="step1" class="slide-up">
            <div class="bg-white shadow-sm p-6 mb-4">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-3 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-hand-holding-heart text-green-600 text-2xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Donation Payment</h2>
                    <p class="text-gray-500 text-sm mt-1">Barangay Cubacub Relief</p>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="text-gray-600">Date & Time</span>
                        <span class="font-semibold text-gray-800" id="currentDateTime"></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="text-gray-600">Recipient</span>
                        <span class="font-semibold text-gray-800">Barangay Cubacub</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="text-gray-600">Account Name</span>
                        <span class="font-semibold text-gray-800">{{ config('payment_accounts.gcash.name') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="text-gray-600">GCash Number</span>
                        <span class="font-mono font-semibold text-gray-800">{{ config('payment_accounts.gcash.number') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-gray-600">Amount</span>
                        <span class="text-3xl font-bold text-blue-600">₱{{ number_format($amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 mx-4">
                <div class="flex">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-1"></i>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-800">
                            <strong>Important:</strong> Please verify the recipient details before proceeding with your donation.
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-4 pb-6">
                <button onclick="showPinEntry()" class="w-full gcash-blue text-white py-4 rounded-lg font-semibold text-lg shadow-lg hover:shadow-xl transition">
                    Continue to Payment
                </button>
            </div>
        </div>

        <!-- Step 2: PIN Entry -->
        <div id="step2" class="hidden">
            <div class="bg-white shadow-sm p-6 mb-4">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Enter your MPIN</h2>
                    <p class="text-gray-500">Please enter your 4-digit MPIN to confirm</p>
                </div>

                <div class="flex justify-center space-x-4 mb-8">
                    <input type="password" maxlength="1" class="pin-input" id="pin1" oninput="moveFocus(this, 'pin2')" onkeydown="handleBackspace(event, this, null)">
                    <input type="password" maxlength="1" class="pin-input" id="pin2" oninput="moveFocus(this, 'pin3')" onkeydown="handleBackspace(event, this, 'pin1')">
                    <input type="password" maxlength="1" class="pin-input" id="pin3" oninput="moveFocus(this, 'pin4')" onkeydown="handleBackspace(event, this, 'pin2')">
                    <input type="password" maxlength="1" class="pin-input" id="pin4" oninput="validatePin()" onkeydown="handleBackspace(event, this, 'pin3')">
                </div>

                <div id="pinError" class="hidden text-center text-red-600 mb-4">
                    <i class="fas fa-exclamation-circle"></i> Incorrect PIN. Please try again.
                </div>

                <div class="text-center">
                    <button onclick="showStep1()" class="text-blue-600 hover:text-blue-700 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </button>
                </div>
            </div>

            <div class="px-4">
                <p class="text-center text-sm text-gray-500">
                    <i class="fas fa-lock mr-1"></i> Your PIN is encrypted and secure
                </p>
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
                <h2 class="text-xl font-bold text-gray-800 mb-2">Processing Payment</h2>
                <p class="text-gray-500">Please wait while we process your donation...</p>
            </div>
        </div>

        <!-- Step 4: Success -->
        <div id="step4" class="hidden">
            <div class="bg-white shadow-sm p-8">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center checkmark-animate">
                        <i class="fas fa-check text-green-600 text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Payment Successful!</h2>
                    <p class="text-gray-500">Thank you for your generous donation</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Reference Number</span>
                            <span class="font-mono font-bold text-blue-600" id="referenceNumber"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Date & Time</span>
                            <span class="font-medium" id="transactionDate"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Amount Paid</span>
                            <span class="font-bold text-lg text-gray-800">₱{{ number_format($amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Recipient</span>
                            <span class="font-medium">Barangay Cubacub Relief</span>
                        </div>
                    </div>
                </div>

                <form id="completeForm" action="{{ route('donor.donations.cash.process', ['method' => 'gcash']) }}" method="POST">
                    @csrf
                    <input type="hidden" name="amount" value="{{ $amount }}">
                    <input type="hidden" name="reference_number" id="hiddenReferenceNumber">
                    <input type="hidden" name="payment_completed" value="1">
                    
                    <button type="submit" class="w-full gcash-blue text-white py-4 rounded-lg font-semibold text-lg shadow-lg hover:shadow-xl transition mb-3">
                        Complete Donation
                    </button>
                </form>

                <button onclick="downloadReceipt()" class="w-full border-2 border-blue-600 text-blue-600 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                    <i class="fas fa-download mr-2"></i>Download Receipt
                </button>
            </div>
        </div>
    </div>

    <script>
        // Generate unique reference number
        function generateReferenceNumber() {
            const timestamp = Date.now();
            const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
            return 'GCASH' + timestamp.toString().slice(-8) + random;
        }

        function showPinEntry() {
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
            document.getElementById('step2').classList.add('slide-up');
            document.getElementById('pin1').focus();
        }

        function showStep1() {
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step1').classList.remove('hidden');
            // Clear PIN inputs
            ['pin1', 'pin2', 'pin3', 'pin4'].forEach(id => {
                document.getElementById(id).value = '';
            });
            document.getElementById('pinError').classList.add('hidden');
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

        function validatePin() {
            const pin1 = document.getElementById('pin1').value;
            const pin2 = document.getElementById('pin2').value;
            const pin3 = document.getElementById('pin3').value;
            const pin4 = document.getElementById('pin4').value;

            if (pin1 && pin2 && pin3 && pin4) {
                // Simulate PIN validation (accept any 4 digits)
                setTimeout(() => {
                    processPayment();
                }, 500);
            }
        }

        function processPayment() {
            // Show processing screen
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step3').classList.remove('hidden');
            document.getElementById('step3').classList.add('slide-up');

            // Simulate processing delay
            setTimeout(() => {
                showSuccess();
            }, 2000);
        }

        function showSuccess() {
            const referenceNumber = generateReferenceNumber();
            const now = new Date();
            const dateStr = now.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric', 
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
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

        function goBack() {
            if (confirm('Are you sure you want to cancel this payment?')) {
                window.location.href = '{{ route('donor.donations.cash.payment', ['method' => 'gcash']) }}';
            }
        }

        // Update current date and time
        function updateDateTime() {
            const now = new Date();
            const dateStr = now.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric', 
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            const dateTimeElement = document.getElementById('currentDateTime');
            if (dateTimeElement) {
                dateTimeElement.textContent = dateStr;
            }
        }

        // Update date/time on page load and every minute
        updateDateTime();
        setInterval(updateDateTime, 60000); // Update every minute

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
