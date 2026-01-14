<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="bg-white p-3 rounded-xl mr-4">
                            <div class="h-10 w-10 bg-purple-600 rounded-md flex items-center justify-center">
                                <span class="text-white font-bold text-lg">PM</span>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-white">PayMaya Payment</h1>
                            <p class="text-purple-100 mt-1">Complete your donation using PayMaya</p>
                        </div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <p class="text-white font-semibold">Amount: <span id="header_amount_display">₱<?php echo e(number_format($amount, 2)); ?></span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 md:p-8">
                <!-- Progress Steps -->
                <div class="mb-8">
                    <div class="flex justify-between relative">
                        <div class="absolute top-4 left-0 right-0 h-1 bg-gray-200 z-0"></div>
                        <div class="absolute top-4 left-0 w-2/3 h-1 bg-purple-500 z-10"></div>
                        <div class="relative z-20 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold">1</div>
                            <span class="mt-2 text-sm font-medium text-gray-700">Payment</span>
                        </div>
                        <div class="relative z-20 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold">2</div>
                            <span class="mt-2 text-sm font-medium text-gray-700">Confirmation</span>
                        </div>
                        <div class="relative z-20 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 font-bold">3</div>
                            <span class="mt-2 text-sm font-medium text-gray-500">Complete</span>
                        </div>
                    </div>
                </div>

                <!-- Amount Selection Section -->
                <div class="mb-8">
                    <label for="donation_amount" class="block text-xl font-bold text-gray-800 mb-4">Donation Amount</label>
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-600 mb-2 uppercase tracking-wider">Enter Amount</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-bold text-2xl">₱</span>
                                <input type="number" 
                                       id="donation_amount" 
                                       class="w-full pl-10 pr-4 py-4 text-3xl font-bold text-gray-800 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-white shadow-sm"
                                       placeholder="0.00"
                                       value="<?php echo e($amount); ?>"
                                       min="1" step="1">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wider">Or Select Amount</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <button type="button" onclick="setAmount(100)" class="amount-btn py-3 px-4 bg-white border-2 border-purple-100 rounded-xl hover:border-purple-500 hover:bg-purple-50 text-purple-700 font-bold text-lg transition-all transform hover:-translate-y-1 shadow-sm">₱100</button>
                                <button type="button" onclick="setAmount(500)" class="amount-btn py-3 px-4 bg-white border-2 border-purple-100 rounded-xl hover:border-purple-500 hover:bg-purple-50 text-purple-700 font-bold text-lg transition-all transform hover:-translate-y-1 shadow-sm">₱500</button>
                                <button type="button" onclick="setAmount(1000)" class="amount-btn py-3 px-4 bg-white border-2 border-purple-100 rounded-xl hover:border-purple-500 hover:bg-purple-50 text-purple-700 font-bold text-lg transition-all transform hover:-translate-y-1 shadow-sm">₱1,000</button>
                                <button type="button" onclick="setAmount(5000)" class="amount-btn py-3 px-4 bg-white border-2 border-purple-100 rounded-xl hover:border-purple-500 hover:bg-purple-50 text-purple-700 font-bold text-lg transition-all transform hover:-translate-y-1 shadow-sm">₱5,000</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Donation Summary -->
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-100 rounded-xl p-6 mb-8">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-receipt text-purple-500 text-xl mr-3"></i>
                        <h3 class="text-xl font-bold text-gray-800">Donation Summary</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Donation Amount:</span>
                            <span class="font-medium" id="summary_donation_amount">₱<?php echo e(number_format($amount, 2)); ?></span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Processing Fee:</span>
                            <span class="font-medium">₱0.00</span>
                        </div>
                        <div class="flex justify-between py-3 font-bold text-lg">
                            <span class="text-gray-800">Total Amount:</span>
                            <span class="text-purple-600" id="summary_total_amount">₱<?php echo e(number_format($amount, 2)); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Pay Now Button -->
                <div class="mb-8">
                    <a href="<?php echo e(route('donor.donations.cash.gateway', ['method' => 'paymaya'])); ?>" 
                       id="pay_now_btn"
                       class="block w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-center py-4 px-6 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                        <i class="fas fa-wallet mr-2"></i>Pay Now with PayMaya
                    </a>
                    <p class="text-center text-sm text-gray-500 mt-3">
                        <i class="fas fa-shield-alt mr-1"></i>Secure payment gateway
                    </p>
                </div>

                <div class="relative mb-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Or pay manually</span>
                    </div>
                </div>

                <!-- PayMaya QR Code -->
                <div class="mb-8">
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Scan to Pay</h3>
                        <p class="text-gray-600 mb-6">Scan the QR code using your PayMaya app to complete the payment</p>
                        
                        <div class="flex justify-center">
                            <div class="relative bg-gradient-to-br from-purple-100 to-indigo-100 p-6 rounded-2xl border-2 border-dashed border-purple-300 shadow-lg">
                                <img src="<?php echo e(asset('images/qr-codes/paymaya-qr.png')); ?>" alt="PayMaya QR Code" class="h-64 w-64 mx-auto object-contain rounded-xl shadow-md">
                                
                                <div class="mt-4 bg-white rounded-lg px-4 py-2 shadow-sm inline-block">
                                    <p class="text-sm font-semibold text-purple-600">
                                        <i class="fas fa-qrcode mr-2"></i>Scan to pay with PayMaya
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Alternative Payment Option -->
                    <div class="bg-gray-50 rounded-xl p-6 mt-6">
                        <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-mobile-alt text-gray-600 mr-2"></i>Or send directly to PayMaya number
                        </h4>
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="bg-white px-6 py-3 rounded-lg font-mono text-lg font-bold border border-gray-200">
                                <?php echo e(config('payment_accounts.paymaya.number')); ?>

                            </div>
                            <button type="button" 
                                    onclick="copyToClipboard('<?php echo e(config('payment_accounts.paymaya.number')); ?>')"
                                    class="w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
                                <i class="fas fa-copy mr-2"></i>Copy Number
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Payment Instructions -->
                <div class="bg-purple-50 border-l-4 border-purple-500 p-5 rounded-lg mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-purple-500 text-xl mt-0.5"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-purple-800 mb-2">How to Pay with PayMaya:</h4>
                            <ol class="list-decimal list-inside text-purple-700 space-y-2">
                                <li>Open your PayMaya app</li>
                                <li>Tap on "Scan QR"</li>
                                <li>Scan the QR code above or send to the PayMaya number</li>
                                <li>Enter the amount: <span class="font-bold" id="instruction_amount">₱<?php echo e(number_format($amount, 2)); ?></span></li>
                                <li>Add a note (optional): "Donation"</li>
                                <li>Review and confirm the payment</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form action="<?php echo e(route('donor.donations.cash.process', ['method' => 'paymaya'])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="amount" id="hidden_amount" value="<?php echo e($amount); ?>">
                    
                    <div class="mb-6">
                        <label for="reference_number" class="block text-lg font-semibold text-gray-800 mb-2">PayMaya Reference Number</label>
                        <p class="text-gray-600 mb-3">Enter the reference number from your PayMaya transaction</p>
                        <input type="text" 
                               id="reference_number" 
                               name="reference_number" 
                               required
                               class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                               placeholder="e.g., PAYMAYA1234567890"
                               value="<?php echo e(old('reference_number')); ?>">
                        <p class="mt-2 text-sm text-gray-500 flex items-center">
                            <i class="fas fa-question-circle mr-2"></i>You can find this in your PayMaya transaction history
                        </p>
                    </div>

                    <div class="flex items-center mb-8 p-4 bg-gray-50 rounded-xl">
                        <input id="terms" name="terms" type="checkbox" required
                               class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="terms" class="ml-3 block text-base text-gray-700">
                            I confirm that I have completed the payment via PayMaya and entered the correct reference number
                        </label>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4 border-t border-gray-200">
                        <a href="<?php echo e(route('donor.donations.cash.index')); ?>" 
                           class="px-6 py-3 border-2 border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Payment Methods
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all flex items-center justify-center">
                            <i class="fas fa-check-circle mr-2"></i>Complete Donation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    const amountInput = document.getElementById('donation_amount');
    const hiddenInput = document.getElementById('hidden_amount');
    const headerDisplay = document.getElementById('header_amount_display');
    const summaryDisplay = document.getElementById('summary_donation_amount');
    const totalDisplay = document.getElementById('summary_total_amount');
    const instructionDisplay = document.getElementById('instruction_amount');
    const payNowBtn = document.getElementById('pay_now_btn');
    
    // Store original href to append query param
    const originalHref = payNowBtn.getAttribute('href');

    function formatCurrency(value) {
        return new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(value);
    }

    function updateDisplays(value) {
        const amount = parseFloat(value) || 0;
        const formatted = formatCurrency(amount);
        
        headerDisplay.textContent = formatted;
        summaryDisplay.textContent = formatted;
        totalDisplay.textContent = formatted;
        instructionDisplay.textContent = formatted;
        
        // Update hidden input
        hiddenInput.value = amount;
        
        // Update Pay Now button URL
        const separator = originalHref.includes('?') ? '&' : '?';
        payNowBtn.setAttribute('href', `${originalHref}${separator}amount=${amount}`);
    }

    function setAmount(amount) {
        amountInput.value = amount;
        updateDisplays(amount);
        
        // Visual feedback for buttons
        // optional: add active state
    }

    // Listen for input changes
    amountInput.addEventListener('input', function(e) {
        updateDisplays(e.target.value);
    });

    // Initialize with default value
    // updateDisplays(amountInput.value); // Optional, PHP already rendered initial values
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.donor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/donor/donations/cash/payment/paymaya.blade.php ENDPATH**/ ?>