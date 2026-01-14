<?php $__env->startPush('scripts'); ?>
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            // Show feedback
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check mr-2"></i>Copied!';
            button.classList.add('bg-green-500', 'hover:bg-green-600');
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('bg-green-500', 'hover:bg-green-600');
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy text: ', err);
        });
    }

    // Refresh CSRF token periodically to prevent expiration
    function refreshCsrfToken() {
        fetch('<?php echo e(route("donor.dashboard")); ?>', {
            method: 'GET',
            credentials: 'same-origin'
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newToken = doc.querySelector('meta[name="csrf-token"]');
            if (newToken) {
                const token = newToken.getAttribute('content');
                document.querySelector('meta[name="csrf-token"]').setAttribute('content', token);
                // Update all CSRF input fields
                document.querySelectorAll('input[name="_token"]').forEach(input => {
                    input.value = token;
                });
            }
        })
        .catch(err => console.error('Failed to refresh CSRF token:', err));
    }

    // Refresh token every 30 minutes
    setInterval(refreshCsrfToken, 30 * 60 * 1000);

    // Handle form submission with CSRF error retry
    document.addEventListener('DOMContentLoaded', function() {
        const amountForm = document.querySelector('form[action*="update-amount"]');
        if (amountForm) {
            amountForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.textContent;
                
                submitButton.disabled = true;
                submitButton.textContent = 'Processing...';
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.status === 419) {
                        // CSRF token expired, refresh and retry
                        return refreshCsrfToken().then(() => {
                            // Update form token
                            formData.set('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                            // Retry the request
                            return fetch(amountForm.action, {
                                method: 'POST',
                                body: formData,
                                credentials: 'same-origin'
                            });
                        });
                    }
                    return response;
                })
                .then(response => {
                    if (response.ok || response.redirected) {
                        window.location.href = response.url || this.action.replace('/amount', '');
                    } else {
                        throw new Error('Request failed');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    submitButton.disabled = false;
                    submitButton.textContent = originalText;
                    alert('An error occurred. Please try again.');
                });
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="bg-white p-3 rounded-xl mr-4">
                            <i class="fas fa-wallet text-3xl text-blue-500"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-white">GCash Payment</h1>
                            <p class="text-blue-100 mt-1">Complete your donation using GCash</p>
                        </div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <p class="text-white font-semibold">Amount: ₱<?php echo e($amount > 0 ? number_format($amount, 2) : '0.00'); ?></p>
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
                        <div class="absolute top-4 left-0 w-2/3 h-1 bg-blue-500 z-10"></div>
                        <div class="relative z-20 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">1</div>
                            <span class="mt-2 text-sm font-medium text-gray-700">Payment</span>
                        </div>
                        <div class="relative z-20 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">2</div>
                            <span class="mt-2 text-sm font-medium text-gray-700">Confirmation</span>
                        </div>
                        <div class="relative z-20 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 font-bold">3</div>
                            <span class="mt-2 text-sm font-medium text-gray-500">Complete</span>
                        </div>
                    </div>
                </div>

                <!-- Donation Amount Input -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-6 mb-8">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-money-bill-wave text-blue-500 text-xl mr-3"></i>
                        <h3 class="text-xl font-bold text-gray-800">Donation Amount</h3>
                    </div>
                    <form action="<?php echo e(route('donor.donations.cash.update-amount', ['method' => 'gcash'])); ?>" method="POST" class="mb-4">
                        <?php echo csrf_field(); ?>
                        <div class="flex items-center">
                            <span class="text-2xl font-bold text-gray-700 mr-2">₱</span>
                            <input type="number" 
                                   name="amount" 
                                   id="donation_amount"
                                   min="1" 
                                   step="0.01" 
                                   value="<?php echo e($amount > 0 ? $amount : ''); ?>"
                                   required
                                   class="text-2xl font-bold border-2 border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter donation amount">
                            <button type="submit" 
                                    class="ml-3 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                                Set Amount
                            </button>
                        </div>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <button type="button" onclick="setAmount(100)" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded text-sm">₱100</button>
                            <button type="button" onclick="setAmount(500)" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded text-sm">₱500</button>
                            <button type="button" onclick="setAmount(1000)" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded text-sm">₱1,000</button>
                            <button type="button" onclick="setAmount(5000)" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded text-sm">₱5,000</button>
                        </div>
                    </form>
                </div>

                <?php if($amount > 0): ?>
                <!-- Donation Summary -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-6 mb-8">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-receipt text-blue-500 text-xl mr-3"></i>
                        <h3 class="text-xl font-bold text-gray-800">Donation Summary</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Date & Time:</span>
                            <span class="font-medium"><?php echo e(now()->format('M d, Y - h:i A')); ?></span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Recipient Name:</span>
                            <span class="font-medium"><?php echo e(config('payment_accounts.gcash.name')); ?></span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">GCash Number:</span>
                            <span class="font-mono font-medium"><?php echo e(config('payment_accounts.gcash.number')); ?></span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Donation Amount:</span>
                            <span class="font-medium">₱<?php echo e(number_format($amount, 2)); ?></span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Processing Fee:</span>
                            <span class="font-medium">₱0.00</span>
                        </div>
                        <div class="flex justify-between py-3 font-bold text-lg">
                            <span class="text-gray-800">Total Amount:</span>
                            <span class="text-blue-600">₱<?php echo e(number_format($amount, 2)); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Pay Now Button -->
                <div class="mb-8">
                    <a href="<?php echo e(route('donor.donations.cash.gateway', ['method' => 'gcash'])); ?>" 
                       class="block w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-center py-4 px-6 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                        <i class="fas fa-mobile-alt mr-2"></i>Pay Now with GCash
                    </a>
                    <p class="text-center text-sm text-gray-500 mt-3">
                        <i class="fas fa-lock mr-1"></i>Secure payment gateway
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

                <!-- GCash QR Code -->
                <div class="mb-8">
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Scan to Pay</h3>
                        <p class="text-gray-600 mb-6">Scan the QR code using your GCash app to complete the payment</p>
                        
                        <div class="flex justify-center">
                            <div class="relative bg-gradient-to-br from-blue-100 to-indigo-100 p-6 rounded-2xl border-2 border-dashed border-blue-300 shadow-lg">
                                <?php
                                    // Define the QR code path relative to public directory
                                    $qrRelativePath = 'images/qr-codes/gcash-qr.png';
                                    $qrFullPath = public_path($qrRelativePath);
                                    
                                    // Check if the directory exists, if not create it
                                    $qrDir = dirname($qrFullPath);
                                    if (!is_dir($qrDir)) {
                                        mkdir($qrDir, 0755, true);
                                    }
                                    
                                    // If QR code doesn't exist, use a placeholder
                                    if (!file_exists($qrFullPath)) {
                                        // Create a placeholder QR code
                                        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?' . http_build_query([
                                            'size' => '512x512',
                                            'data' => 'GCash Payment: ₱' . number_format($amount, 2) . ' - ' . config('app.name'),
                                            'margin' => '10',
                                            'qzone' => '2',
                                            'format' => 'png'
                                        ]);
                                        
                                        // Try to save the QR code for future use
                                        try {
                                            $qrContent = file_get_contents($qrCodeUrl);
                                            if ($qrContent !== false) {
                                                file_put_contents($qrFullPath, $qrContent);
                                                $qrCodeUrl = asset($qrRelativePath) . '?v=' . time();
                                            }
                                        } catch (Exception $e) {
                                            // If saving fails, continue with the generated URL
                                        }
                                    } else {
                                        // Use the local QR code with cache buster
                                        $qrCodeUrl = asset($qrRelativePath) . '?v=' . filemtime($qrFullPath);
                                    }
                                ?>
                                
                                <img src="<?php echo e($qrCodeUrl); ?>" 
                                     alt="GCash QR Code" 
                                     class="h-64 w-64 mx-auto object-contain rounded-xl shadow-md"
                                     onerror="this.onerror=null; this.src='<?php echo e(asset('images/placeholder-qr.png')); ?>';">
                                
                                <div class="mt-4 bg-white rounded-lg px-4 py-2 shadow-sm inline-block">
                                    <p class="text-sm font-semibold text-blue-600">
                                        <i class="fas fa-qrcode mr-2"></i>Scan to pay with GCash
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Alternative Payment Option -->
                    <div class="bg-gray-50 rounded-xl p-6 mt-6">
                        <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-mobile-alt text-gray-600 mr-2"></i>Or send directly to GCash number
                        </h4>
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="bg-white px-6 py-3 rounded-lg font-mono text-lg font-bold border border-gray-200">
                                <?php echo e(config('payment_accounts.gcash.number')); ?>

                            </div>
                            <button type="button" 
                                    onclick="copyToClipboard('<?php echo e(config('payment_accounts.gcash.number')); ?>')" 
                                    class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
                                <i class="fas fa-copy mr-2"></i>Copy Number
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Payment Instructions -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-5 rounded-lg mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-500 text-xl mt-0.5"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-blue-800 mb-2">How to Pay with GCash:</h4>
                            <ol class="list-decimal list-inside text-blue-700 space-y-2">
                                <li>Open your GCash app</li>
                                <li>Tap on "Scan QR"</li>
                                <li>Scan the QR code above or send to the GCash number</li>
                                <li>Enter the amount: <span class="font-bold">₱<?php echo e(number_format($amount, 2)); ?></span></li>
                                <li>Add a note (optional): "Donation"</li>
                                <li>Review and confirm the payment</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form action="<?php echo e(route('donor.donations.cash.process', ['method' => 'gcash'])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="amount" value="<?php echo e($amount); ?>">
                    
                    <div class="mb-6">
                        <label for="reference_number" class="block text-lg font-semibold text-gray-800 mb-2">
                            GCash Reference Number
                            <span class="text-sm font-normal text-green-600 ml-2">
                                <i class="fas fa-check-circle"></i> Auto-generated
                            </span>
                        </label>
                        <p class="text-gray-600 mb-3">A unique reference number has been automatically generated. You may edit it if you have your own GCash transaction reference.</p>
                        <input type="text" 
                               id="reference_number" 
                               name="reference_number" 
                               required
                               class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                               placeholder="e.g., GCASH1234567890"
                               value="<?php echo e(old('reference_number')); ?>">
                        <p class="mt-2 text-sm text-gray-500 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>This reference number will be used to track your donation
                        </p>
                        <?php $__errorArgs = ['reference_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i><?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex items-center mb-8 p-4 bg-gray-50 rounded-xl">
                        <input id="terms" name="terms" type="checkbox" required
                               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="terms" class="ml-3 block text-base text-gray-700">
                            I confirm that I have completed the payment via GCash and entered the correct reference number
                        </label>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4 border-t border-gray-200">
                        <a href="<?php echo e(route('donor.donations.cash.index')); ?>" 
                           class="px-6 py-3 border-2 border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Payment Methods
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all flex items-center justify-center">
                            <i class="fas fa-check-circle mr-2"></i>Complete Donation
                        </button>
                    </div>
                </form>
                <?php else: ?>
                <div class="text-center py-8">
                    <i class="fas fa-info-circle text-blue-500 text-4xl mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Enter Donation Amount</h3>
                    <p class="text-gray-600">Please enter a donation amount above to proceed with your GCash payment.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function setAmount(amount) {
        document.getElementById('donation_amount').value = amount;
    }

    // Generate unique GCash reference number
    function generateGCashReference() {
        const timestamp = Date.now();
        const random = Math.floor(Math.random() * 100000).toString().padStart(5, '0');
        return 'GCASH' + timestamp.toString().slice(-10) + random;
    }

    // Auto-fill reference number when page loads
    document.addEventListener('DOMContentLoaded', function() {
        const referenceInput = document.getElementById('reference_number');
        if (referenceInput && !referenceInput.value) {
            const uniqueReference = generateGCashReference();
            referenceInput.value = uniqueReference;
            
            // Add a subtle highlight effect to show it was auto-filled
            referenceInput.classList.add('bg-green-50');
            setTimeout(() => {
                referenceInput.classList.remove('bg-green-50');
            }, 2000);
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.donor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/donor/donations/cash/payment/gcash.blade.php ENDPATH**/ ?>