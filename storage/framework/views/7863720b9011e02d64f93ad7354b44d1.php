<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayMaya - Secure Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        .paymaya-green { background: linear-gradient(135deg, #00D632 0%, #00B028 100%); }
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
            border-color: #00D632;
            box-shadow: 0 0 0 3px rgba(0, 214, 50, 0.1);
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
    <!-- PayMaya Header -->
    <div class="paymaya-green text-white px-4 py-4 shadow-lg">
        <div class="max-w-md mx-auto flex items-center justify-between">
            <button onclick="goBack()" class="text-white hover:bg-white/20 rounded-full p-2 transition">
                <i class="fas fa-arrow-left text-xl"></i>
            </button>
            <div class="flex items-center space-x-2">
                <div class="bg-white rounded-lg px-3 py-1">
                    <span class="text-green-600 font-bold text-xl">PayMaya</span>
                </div>
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
                    <div class="w-16 h-16 mx-auto mb-3 paymaya-green rounded-full flex items-center justify-center">
                        <i class="fas fa-hand-holding-heart text-white text-2xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Secure Checkout</h2>
                    <p class="text-gray-500 text-sm mt-1">Barangay Cubacub Relief & Donation</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 mb-6">
                    <div class="text-center mb-4">
                        <p class="text-sm text-gray-600 mb-2">Amount to Pay</p>
                        <p class="text-4xl font-bold text-green-600">₱<?php echo e(number_format($amount, 2)); ?></p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between py-3 border-b">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-gray-400 mr-3"></i>
                            <span class="text-gray-600">Date & Time</span>
                        </div>
                        <span class="font-semibold text-gray-800" id="currentDateTime"></span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b">
                        <div class="flex items-center">
                            <i class="fas fa-building text-gray-400 mr-3"></i>
                            <span class="text-gray-600">Merchant</span>
                        </div>
                        <span class="font-semibold text-gray-800">Barangay Cubacub</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b">
                        <div class="flex items-center">
                            <i class="fas fa-user text-gray-400 mr-3"></i>
                            <span class="text-gray-600">Account Name</span>
                        </div>
                        <span class="font-semibold text-gray-800"><?php echo e(config('payment_accounts.paymaya.name')); ?></span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b">
                        <div class="flex items-center">
                            <i class="fas fa-mobile-alt text-gray-400 mr-3"></i>
                            <span class="text-gray-600">PayMaya Number</span>
                        </div>
                        <span class="font-mono font-semibold text-gray-800"><?php echo e(config('payment_accounts.paymaya.number')); ?></span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b">
                        <div class="flex items-center">
                            <i class="fas fa-tag text-gray-400 mr-3"></i>
                            <span class="text-gray-600">Description</span>
                        </div>
                        <span class="font-medium text-gray-800">Donation</span>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <div class="flex items-center">
                            <i class="fas fa-shield-alt text-gray-400 mr-3"></i>
                            <span class="text-gray-600">Payment Method</span>
                        </div>
                        <span class="font-medium text-green-600">PayMaya Wallet</span>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 mx-4">
                <div class="flex">
                    <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                    <div class="ml-3">
                        <p class="text-sm text-blue-800">
                            Your payment is protected by PayMaya's secure payment system.
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-4 pb-6">
                <button onclick="showPinEntry()" class="w-full paymaya-green text-white py-4 rounded-lg font-semibold text-lg shadow-lg hover:shadow-xl transition">
                    Proceed to Pay
                </button>
            </div>
        </div>

        <!-- Step 2: PIN Entry -->
        <div id="step2" class="hidden">
            <div class="bg-white shadow-sm p-6 mb-4">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-lock text-green-600 text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Enter PIN</h2>
                    <p class="text-gray-500">Enter your 6-digit PayMaya PIN</p>
                </div>

                <div class="flex justify-center space-x-3 mb-8">
                    <input type="password" maxlength="1" class="pin-input" id="pin1" oninput="moveFocus(this, 'pin2')" onkeydown="handleBackspace(event, this, null)">
                    <input type="password" maxlength="1" class="pin-input" id="pin2" oninput="moveFocus(this, 'pin3')" onkeydown="handleBackspace(event, this, 'pin1')">
                    <input type="password" maxlength="1" class="pin-input" id="pin3" oninput="moveFocus(this, 'pin4')" onkeydown="handleBackspace(event, this, 'pin2')">
                    <input type="password" maxlength="1" class="pin-input" id="pin4" oninput="moveFocus(this, 'pin5')" onkeydown="handleBackspace(event, this, 'pin3')">
                    <input type="password" maxlength="1" class="pin-input" id="pin5" oninput="moveFocus(this, 'pin6')" onkeydown="handleBackspace(event, this, 'pin4')">
                    <input type="password" maxlength="1" class="pin-input" id="pin6" oninput="validatePin()" onkeydown="handleBackspace(event, this, 'pin5')">
                </div>

                <div id="pinError" class="hidden text-center text-red-600 mb-4">
                    <i class="fas fa-exclamation-circle"></i> Incorrect PIN. Please try again.
                </div>

                <div class="text-center">
                    <button onclick="showStep1()" class="text-green-600 hover:text-green-700 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </button>
                </div>
            </div>

            <div class="px-4">
                <div class="bg-gray-100 rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-600">
                        <i class="fas fa-shield-alt mr-1"></i> 
                        Secured by PayMaya 256-bit SSL encryption
                    </p>
                </div>
            </div>
        </div>

        <!-- Step 3: Processing -->
        <div id="step3" class="hidden">
            <div class="bg-white shadow-sm p-8 text-center">
                <div class="mb-6">
                    <div class="inline-block">
                        <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-green-600"></div>
                    </div>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Processing Payment</h2>
                <p class="text-gray-500">Verifying your transaction...</p>
                <p class="text-sm text-gray-400 mt-2">This may take a few seconds</p>
            </div>
        </div>

        <!-- Step 4: Success -->
        <div id="step4" class="hidden">
            <div class="bg-white shadow-sm p-8">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 mx-auto mb-4 paymaya-green rounded-full flex items-center justify-center checkmark-animate">
                        <i class="fas fa-check text-white text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Payment Successful!</h2>
                    <p class="text-gray-500">Your donation has been processed</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 mb-6">
                    <div class="space-y-4">
                        <div class="text-center pb-4 border-b border-green-200">
                            <p class="text-sm text-gray-600 mb-1">Transaction Reference</p>
                            <p class="text-xl font-mono font-bold text-green-600" id="referenceNumber"></p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600 mb-1">Date & Time</p>
                                <p class="font-medium text-gray-800" id="transactionDate"></p>
                            </div>
                            <div>
                                <p class="text-gray-600 mb-1">Amount</p>
                                <p class="font-bold text-lg text-gray-800">₱<?php echo e(number_format($amount, 2)); ?></p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-green-200">
                            <p class="text-gray-600 text-sm mb-1">Recipient</p>
                            <p class="font-semibold text-gray-800">Barangay Cubacub Relief & Donation</p>
                        </div>
                    </div>
                </div>

                <form id="completeForm" action="<?php echo e(route('donor.donations.cash.process', ['method' => 'paymaya'])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="amount" value="<?php echo e($amount); ?>">
                    <input type="hidden" name="reference_number" id="hiddenReferenceNumber">
                    <input type="hidden" name="payment_completed" value="1">
                    
                    <button type="submit" class="w-full paymaya-green text-white py-4 rounded-lg font-semibold text-lg shadow-lg hover:shadow-xl transition mb-3">
                        Complete Donation
                    </button>
                </form>

                <button onclick="downloadReceipt()" class="w-full border-2 border-green-600 text-green-600 py-3 rounded-lg font-semibold hover:bg-green-50 transition">
                    <i class="fas fa-download mr-2"></i>Download Receipt
                </button>
            </div>
        </div>
    </div>

    <script>
        // Generate unique reference number
        function generateReferenceNumber() {
            const timestamp = Date.now();
            const random = Math.floor(Math.random() * 100000).toString().padStart(5, '0');
            return 'PM' + timestamp.toString().slice(-10) + random;
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
            ['pin1', 'pin2', 'pin3', 'pin4', 'pin5', 'pin6'].forEach(id => {
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
            const pins = ['pin1', 'pin2', 'pin3', 'pin4', 'pin5', 'pin6'];
            const allFilled = pins.every(id => document.getElementById(id).value !== '');

            if (allFilled) {
                // Simulate PIN validation (accept any 6 digits)
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
            }, 2500);
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
                window.location.href = '<?php echo e(route('donor.donations.cash.payment', ['method' => 'paymaya'])); ?>';
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
<?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/donor/donations/cash/payment/paymaya-gateway.blade.php ENDPATH**/ ?>