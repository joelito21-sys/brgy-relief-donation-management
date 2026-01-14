<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="bg-white p-3 rounded-xl mr-4">
                            <i class="fas fa-building-columns text-3xl text-green-500"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-white">Bank Transfer</h1>
                            <p class="text-green-100 mt-1">Complete your donation via bank transfer</p>
                        </div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <p class="text-white font-semibold">Amount: ₱<?php echo e(number_format($amount, 2)); ?></p>
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
                        <div class="absolute top-4 left-0 w-2/3 h-1 bg-green-500 z-10"></div>
                        <div class="relative z-20 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white font-bold">1</div>
                            <span class="mt-2 text-sm font-medium text-gray-700">Payment</span>
                        </div>
                        <div class="relative z-20 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white font-bold">2</div>
                            <span class="mt-2 text-sm font-medium text-gray-700">Confirmation</span>
                        </div>
                        <div class="relative z-20 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 font-bold">3</div>
                            <span class="mt-2 text-sm font-medium text-gray-500">Complete</span>
                        </div>
                    </div>
                </div>

                <!-- Donation Summary -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-100 rounded-xl p-6 mb-8">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-receipt text-green-500 text-xl mr-3"></i>
                        <h3 class="text-xl font-bold text-gray-800">Donation Summary</h3>
                    </div>
                    <div class="space-y-3">
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
                            <span class="text-green-600">₱<?php echo e(number_format($amount, 2)); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Pay Now Button -->
                <div class="mb-8">
                    <a href="<?php echo e(route('donor.donations.cash.gateway', ['method' => 'bank'])); ?>" 
                       class="block w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white text-center py-4 px-6 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                        <i class="fas fa-university mr-2"></i>Pay Now via Online Banking
                    </a>
                    <p class="text-center text-sm text-gray-500 mt-3">
                        <i class="fas fa-shield-alt mr-1"></i>Secure bank transfer gateway
                    </p>
                </div>

                <div class="relative mb-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Or transfer manually</span>
                    </div>
                </div>

                <!-- Bank Details -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Bank Account Details</h3>
                    <p class="text-gray-600 mb-6">Transfer your donation to any of the following bank accounts</p>
                    
                    <!-- Bank Selection Tabs -->
                    <div class="mb-6">
                        <div class="border-b border-gray-200">
                            <nav class="flex flex-wrap -mb-px" aria-label="Tabs">
                                <button type="button" data-bank="bpi" 
                                        class="bank-tab whitespace-nowrap py-4 px-6 border-b-2 font-medium text-base border-green-500 text-green-600">
                                    BPI
                                </button>
                                <button type="button" data-bank="bdo" 
                                        class="bank-tab whitespace-nowrap py-4 px-6 border-b-2 font-medium text-base border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    BDO
                                </button>
                                <button type="button" data-bank="metrobank" 
                                        class="bank-tab whitespace-nowrap py-4 px-6 border-b-2 font-medium text-base border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Metrobank
                                </button>
                            </nav>
                        </div>
                    </div>
                    
                    <!-- BPI Bank Details -->
                    <div id="bpi-details" class="bank-details">
                        <div class="bg-gradient-to-br from-red-50 to-orange-50 p-6 rounded-xl border border-red-100 shadow-sm">
                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6">
                                <div class="flex items-center mb-4 md:mb-0">
                                    <div class="h-12 w-12 bg-red-600 rounded-xl flex items-center justify-center mr-4">
                                        <span class="text-white font-bold text-xl">BPI</span>
                                    </div>
                                    <div>
                                        <h4 class="text-xl font-bold text-gray-900">BPI Bank</h4>
                                        <p class="text-gray-600">Bank of the Philippine Islands</p>
                                    </div>
                                </div>
                                <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg font-semibold">
                                    <i class="fas fa-star mr-1"></i>Recommended
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Account Name</p>
                                    <div class="flex items-center justify-between">
                                        <p class="font-medium text-gray-900"><?php echo e(config('payment_accounts.bank.bpi.account_name')); ?></p>
                                        <button type="button" class="text-green-600 hover:text-green-800 ml-2" onclick="copyToClipboard('<?php echo e(config('payment_accounts.bank.bpi.account_name')); ?>')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Account Number</p>
                                    <div class="flex items-center justify-between">
                                        <p class="font-mono font-medium text-gray-900"><?php echo e(config('payment_accounts.bank.bpi.account_number')); ?></p>
                                        <button type="button" class="text-green-600 hover:text-green-800 ml-2" onclick="copyToClipboard('<?php echo e(str_replace(' ', '', config('payment_accounts.bank.bpi.account_number'))); ?>')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Account Type</p>
                                    <p class="font-medium text-gray-900">Savings Account</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Branch</p>
                                    <p class="font-medium text-gray-900">BPI Main Branch</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- BDO Bank Details (Hidden by default) -->
                    <div id="bdo-details" class="bank-details hidden">
                        <div class="bg-gradient-to-br from-red-50 to-pink-50 p-6 rounded-xl border border-red-100 shadow-sm">
                            <div class="flex items-center mb-6">
                                <div class="h-12 w-12 bg-red-700 rounded-xl flex items-center justify-center mr-4">
                                    <span class="text-white font-bold text-xl">BDO</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900">BDO Unibank</h4>
                                    <p class="text-gray-600">Banco de Oro Unibank</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Account Name</p>
                                    <div class="flex items-center justify-between">
                                        <p class="font-medium text-gray-900"><?php echo e(config('payment_accounts.bank.bdo.account_name')); ?></p>
                                        <button type="button" class="text-green-600 hover:text-green-800 ml-2" onclick="copyToClipboard('<?php echo e(config('payment_accounts.bank.bdo.account_name')); ?>')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Account Number</p>
                                    <div class="flex items-center justify-between">
                                        <p class="font-mono font-medium text-gray-900"><?php echo e(config('payment_accounts.bank.bdo.account_number')); ?></p>
                                        <button type="button" class="text-green-600 hover:text-green-800 ml-2" onclick="copyToClipboard('<?php echo e(str_replace(' ', '', config('payment_accounts.bank.bdo.account_number'))); ?>')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Account Type</p>
                                    <p class="font-medium text-gray-900">Savings Account</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Branch</p>
                                    <p class="font-medium text-gray-900"><?php echo e(config('payment_accounts.bank.bdo.branch')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Metrobank Details (Hidden by default) -->
                    <div id="metrobank-details" class="bank-details hidden">
                        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-6 rounded-xl border border-blue-100 shadow-sm">
                            <div class="flex items-center mb-6">
                                <div class="h-12 w-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
                                    <span class="text-white font-bold text-xl">MB</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900">Metrobank</h4>
                                    <p class="text-gray-600">Metrobank Direct</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Account Name</p>
                                    <div class="flex items-center justify-between">
                                        <p class="font-medium text-gray-900"><?php echo e(config('payment_accounts.bank.metrobank.account_name')); ?></p>
                                        <button type="button" class="text-green-600 hover:text-green-800 ml-2" onclick="copyToClipboard('<?php echo e(config('payment_accounts.bank.metrobank.account_name')); ?>')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Account Number</p>
                                    <div class="flex items-center justify-between">
                                        <p class="font-mono font-medium text-gray-900"><?php echo e(config('payment_accounts.bank.metrobank.account_number')); ?></p>
                                        <button type="button" class="text-green-600 hover:text-green-800 ml-2" onclick="copyToClipboard('<?php echo e(str_replace(' ', '', config('payment_accounts.bank.metrobank.account_number'))); ?>')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Account Type</p>
                                    <p class="font-medium text-gray-900">Savings Account</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Branch</p>
                                    <p class="font-medium text-gray-900"><?php echo e(config('payment_accounts.bank.metrobank.branch')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Instructions -->
                <div class="bg-green-50 border-l-4 border-green-500 p-5 rounded-lg mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-green-500 text-xl mt-0.5"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-green-800 mb-2">How to Complete Your Donation:</h4>
                            <ol class="list-decimal list-inside text-green-700 space-y-2">
                                <li>Transfer your donation of <span class="font-bold">₱<?php echo e(number_format($amount, 2)); ?></span> to any of the bank accounts above</li>
                                <li>After completing the transfer, fill out the form below with the transaction details</li>
                                <li>Upload a screenshot or photo of the transaction receipt (optional but recommended)</li>
                                <li>Click "Submit Donation" to complete your donation</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form action="<?php echo e(route('donor.donations.cash.process', ['method' => 'bank'])); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="amount" value="<?php echo e($amount); ?>">
                    <input type="hidden" name="bank_name" id="bank_name" value="BPI">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="sender_name" class="block text-lg font-semibold text-gray-800 mb-2">Sender's Name</label>
                            <p class="text-gray-600 mb-3">Name as it appears on your bank account</p>
                            <input type="text" id="sender_name" name="sender_name" required
                                   class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                   placeholder="Your full name"
                                   value="<?php echo e(old('sender_name')); ?>">
                        </div>
                        <div>
                            <label for="reference_number" class="block text-lg font-semibold text-gray-800 mb-2">Reference/Transaction Number</label>
                            <p class="text-gray-600 mb-3">From your bank transaction</p>
                            <input type="text" id="reference_number" name="reference_number" required
                                   class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                   placeholder="e.g., TXN1234567890"
                                   value="<?php echo e(old('reference_number')); ?>">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="receipt" class="block text-lg font-semibold text-gray-800 mb-2">Upload Receipt (Optional)</label>
                        <p class="text-gray-600 mb-3">Screenshot or photo of your transaction receipt</p>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-xl">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mx-auto"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="receipt" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500">
                                        <span>Upload a file</span>
                                        <input id="receipt" name="receipt" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, PDF up to 5MB</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="message" class="block text-lg font-semibold text-gray-800 mb-2">Message (Optional)</label>
                        <p class="text-gray-600 mb-3">Add a personal message or dedication</p>
                        <textarea id="message" name="message" rows="4"
                                  class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                  placeholder="Your message here..."><?php echo e(old('message')); ?></textarea>
                    </div>

                    <div class="flex items-start mb-8 p-4 bg-gray-50 rounded-xl">
                        <input id="terms" name="terms" type="checkbox" required
                               class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300 rounded mt-1">
                        <label for="terms" class="ml-3 block text-base text-gray-700">
                            I confirm that I have completed the bank transfer to the selected account with the details provided above. I understand that my donation will be verified upon receipt of the transaction details.
                        </label>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4 border-t border-gray-200">
                        <a href="<?php echo e(route('donor.donations.cash.index')); ?>" 
                           class="px-6 py-3 border-2 border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Payment Methods
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>Submit Donation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Bank tab switching
    document.querySelectorAll('.bank-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const bank = this.getAttribute('data-bank');
            
            // Update active tab
            document.querySelectorAll('.bank-tab').forEach(t => {
                t.classList.remove('border-green-500', 'text-green-600');
                t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });
            this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            this.classList.add('border-green-500', 'text-green-600');
            
            // Show selected bank details
            document.querySelectorAll('.bank-details').forEach(detail => {
                detail.classList.add('hidden');
            });
            document.getElementById(`${bank}-details`).classList.remove('hidden');
            
            // Update hidden bank name field
            document.getElementById('bank_name').value = bank.toUpperCase();
        });
    });
    
    // Copy to clipboard function
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show a small toast or tooltip to indicate success
            const toast = document.createElement('div');
            toast.innerHTML = '<i class="fas fa-check mr-2"></i>Copied to clipboard!';
            toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-4 py-3 rounded-xl shadow-lg text-base font-medium flex items-center';
            document.body.appendChild(toast);
            
            // Remove the toast after 2 seconds
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 2000);
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.donor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/donor/donations/cash/payment/bank.blade.php ENDPATH**/ ?>