

<?php $__env->startSection('title', 'Edit Relief Request'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #0284c7 0%, #1e40af 50%, #1e3a8a 100%);
    }
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .floating-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
    }
    .shape {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
        animation: float 15s infinite linear;
    }
    .shape-1 {
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        top: 10%;
        left: 5%;
        animation-duration: 20s;
    }
    .shape-2 {
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, #10b981, #3b82f6);
        bottom: 15%;
        right: 10%;
        animation-duration: 25s;
        animation-delay: -5s;
    }
    @keyframes float {
        '0%, 100%': { transform: 'translateY(0)' },
        '50%': { transform: 'translateY(-10px)' },
    }
    .form-input {
        transition: all 0.3s ease;
    }
    .form-input:focus {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.1);
    }
    .submit-btn {
        background: linear-gradient(135deg, #10b981, #059669) !important;
        color: white !important;
        border: 2px solid #10b981 !important;
        transition: all 0.3s ease;
        padding: 12px 32px;
        font-weight: 600;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
        background: linear-gradient(135deg, #059669, #047857) !important;
        border-color: #059669 !important;
    }
    .cancel-btn {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        color: white !important;
        border: 2px solid #ef4444 !important;
        transition: all 0.3s ease;
        padding: 12px 32px;
        font-weight: 600;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    .cancel-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(239, 68, 68, 0.3);
        background: linear-gradient(135deg, #dc2626, #b91c1c) !important;
        color: white !important;
        border-color: #dc2626 !important;
    }
    .urgency-badge {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        '0%, 100%': { opacity: 1 },
        '50%': { opacity: 0.7 },
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen relative">
    <!-- Animated Background -->
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    <!-- Gradient Background -->
    <div class="gradient-bg min-h-screen py-8">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-8 animate-fade-in">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full mb-4">
                        <i class="fas fa-edit text-3xl text-white"></i>
                    </div>
                    <h1 class="text-4xl font-bold text-white mb-4">Edit Relief Request</h1>
                    <p class="text-xl text-white/90 max-w-2xl mx-auto">
                       Update the details of your relief request #<?php echo e($reliefRequest->id); ?>.
                    </p>
                </div>

                <!-- Main Content -->
                <div class="glass-effect rounded-2xl shadow-2xl p-8">
                    <form action="<?php echo e(route('resident.relief-requests.update', $reliefRequest->id)); ?>" method="POST" class="space-y-8">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <!-- Personal Information -->
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div class="bg-blue-100 rounded-lg p-2 mr-3">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                Personal Information
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-user mr-2 text-gray-400"></i>Full Name
                                    </label>
                                    <input type="text" 
                                           name="full_name" 
                                           value="<?php echo e(old('full_name', $reliefRequest->full_name)); ?>"
                                           required
                                           class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter your full name">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-phone mr-2 text-gray-400"></i>Contact Number
                                    </label>
                                    <input type="tel" 
                                           name="contact_number"
                                           value="<?php echo e(old('contact_number', $reliefRequest->contact_number)); ?>"
                                           required
                                           class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter your contact number">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-envelope mr-2 text-gray-400"></i>Email Address
                                    </label>
                                    <input type="email" 
                                           name="email_address"
                                           value="<?php echo e(old('email_address', $reliefRequest->email_address)); ?>"
                                           required
                                           class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter your email address">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-id-card mr-2 text-gray-400"></i>ID Number
                                    </label>
                                    <input type="text" 
                                           name="id_number"
                                           value="<?php echo e(old('id_number', $reliefRequest->id_number)); ?>"
                                           required
                                           class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter your government ID number">
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div class="bg-green-100 rounded-lg p-2 mr-3">
                                    <i class="fas fa-map-marker-alt text-green-600"></i>
                                </div>
                                Address Information
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-home mr-2 text-gray-400"></i>Purok / Sitio / Specific Address
                                    </label>
                                    <input type="text" 
                                           name="complete_address" 
                                           value="<?php echo e(old('complete_address', $reliefRequest->complete_address)); ?>"
                                           required
                                           class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter complete address details">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-city mr-2 text-gray-400"></i>City/Municipality
                                    </label>
                                    <select name="city_municipality"
                                            required
                                            class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="Mandaue City" <?php echo e(old('city_municipality', $reliefRequest->city_municipality) == 'Mandaue City' ? 'selected' : ''); ?>>Mandaue City</option>
                                        <option value="Consolacion" <?php echo e(old('city_municipality', $reliefRequest->city_municipality) == 'Consolacion' ? 'selected' : ''); ?>>Consolacion</option>
                                        <option value="Cebu City" <?php echo e(old('city_municipality', $reliefRequest->city_municipality) == 'Cebu City' ? 'selected' : ''); ?>>Cebu City</option>
                                        <option value="Lapu-Lapu City" <?php echo e(old('city_municipality', $reliefRequest->city_municipality) == 'Lapu-Lapu City' ? 'selected' : ''); ?>>Lapu-Lapu City</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-map mr-2 text-gray-400"></i>Province
                                    </label>
                                    <select name="province"
                                            required
                                            class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="Cebu" <?php echo e(old('province', $reliefRequest->province) == 'Cebu' ? 'selected' : ''); ?>>Cebu</option>
                                        <option value="Bohol" <?php echo e(old('province', $reliefRequest->province) == 'Bohol' ? 'selected' : ''); ?>>Bohol</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-map-pin mr-2 text-gray-400"></i>Postal Code
                                    </label>
                                    <select name="postal_code"
                                            class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="6014" <?php echo e(old('postal_code', $reliefRequest->postal_code) == '6014' ? 'selected' : ''); ?>>6014</option>
                                        <option value="6000" <?php echo e(old('postal_code', $reliefRequest->postal_code) == '6000' ? 'selected' : ''); ?>>6000</option>
                                        <option value="6001" <?php echo e(old('postal_code', $reliefRequest->postal_code) == '6001' ? 'selected' : ''); ?>>6001</option>
                                        <option value="6015" <?php echo e(old('postal_code', $reliefRequest->postal_code) == '6015' ? 'selected' : ''); ?>>6015</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-users mr-2 text-gray-400"></i>Household Size
                                    </label>
                                    <input type="number" 
                                           name="household_size"
                                           value="<?php echo e(old('household_size', $reliefRequest->household_size)); ?>"
                                           min="1"
                                           required
                                           class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Number of family members">
                                </div>
                            </div>
                        </div>

                        <!-- Relief Request Details -->
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div class="bg-orange-100 rounded-lg p-2 mr-3">
                                    <i class="fas fa-hands-helping text-orange-600"></i>
                                </div>
                                Relief Request Details
                            </h2>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-exclamation-triangle mr-2 text-gray-400"></i>Urgency Level
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="urgency_level" value="low" class="peer sr-only" required <?php echo e(old('urgency_level', $reliefRequest->urgency_level) == 'low' ? 'checked' : ''); ?>>
                                            <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition-all">
                                                <div class="flex items-center">
                                                    <i class="fas fa-clock text-green-600 mr-3"></i>
                                                    <div>
                                                        <p class="font-semibold text-gray-800">Low</p>
                                                        <p class="text-sm text-gray-600">Can wait 3-5 days</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="urgency_level" value="medium" class="peer sr-only" <?php echo e(old('urgency_level', $reliefRequest->urgency_level) == 'medium' ? 'checked' : ''); ?>>
                                            <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-yellow-500 peer-checked:bg-yellow-50 hover:border-yellow-300 transition-all">
                                                <div class="flex items-center">
                                                    <i class="fas fa-exclamation-circle text-yellow-600 mr-3 urgency-badge"></i>
                                                    <div>
                                                        <p class="font-semibold text-gray-800">Medium</p>
                                                        <p class="text-sm text-gray-600">Need within 1-2 days</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="urgency_level" value="high" class="peer sr-only" <?php echo e(old('urgency_level', $reliefRequest->urgency_level) == 'high' ? 'checked' : ''); ?>>
                                            <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-red-500 peer-checked:bg-red-50 hover:border-red-300 transition-all">
                                                <div class="flex items-center">
                                                    <i class="fas fa-exclamation-triangle text-red-600 mr-3 urgency-badge"></i>
                                                    <div>
                                                        <p class="font-semibold text-gray-800">High</p>
                                                        <p class="text-sm text-gray-600">Immediate assistance needed</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-list mr-2 text-gray-400"></i>Type of Assistance Needed
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <?php
                                            $assistanceTypes = $reliefRequest->assistance_types ?? [];
                                            // Handle potential encoded JSON if it's a string
                                            if (is_string($assistanceTypes)) {
                                                $assistanceTypes = json_decode($assistanceTypes, true) ?? [];
                                            }
                                            
                                            // Check for Cash amount logic
                                            $hasCash = false;
                                            $cashAmount = '';
                                            foreach($assistanceTypes as $type) {
                                                if (str_contains($type, 'Cash')) {
                                                    $hasCash = true;
                                                    // Extract numbers from "Cash (₱1,000)" format
                                                    preg_match('/₱([0-9,]+)/', $type, $matches);
                                                    if (isset($matches[1])) {
                                                        $cashAmount = str_replace(',', '', $matches[1]);
                                                    }
                                                    break;
                                                }
                                            }
                                        ?>
                                        <div class="col-span-1">
                                            <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg hover:border-blue-300 cursor-pointer w-full">
                                                <input type="checkbox" name="assistance_types[]" value="cash" class="mr-3" id="cash_checkbox" onchange="toggleCashAmount()" <?php echo e($hasCash ? 'checked' : ''); ?>>
                                                <i class="fas fa-dollar-sign text-blue-600 mr-2"></i>
                                                <span>Cash</span>
                                            </label>
                                            <div id="cash_amount_container" class="<?php echo e($hasCash ? '' : 'hidden'); ?> mt-2">
                                                <select name="cash_amount" 
                                                       class="form-input w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="" disabled <?php echo e(!$hasCash ? 'selected' : ''); ?>>Select amount</option>
                                                    <?php for($i = 1000; $i <= 10000; $i += 500): ?>
                                                        <option value="<?php echo e($i); ?>" <?php echo e($cashAmount == $i ? 'selected' : ''); ?>>₱<?php echo e(number_format($i)); ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg hover:border-blue-300 cursor-pointer">
                                            <input type="checkbox" name="assistance_types[]" value="food" class="mr-3" <?php echo e(in_array('food', $assistanceTypes) ? 'checked' : ''); ?>>
                                            <i class="fas fa-utensils text-blue-600 mr-2"></i>
                                            <span>Food Supplies</span>
                                        </label>

                                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg hover:border-blue-300 cursor-pointer">
                                            <input type="checkbox" name="assistance_types[]" value="water" class="mr-3" <?php echo e(in_array('water', $assistanceTypes) ? 'checked' : ''); ?>>
                                            <i class="fas fa-tint text-blue-600 mr-2"></i>
                                            <span>Clean Water</span>
                                        </label>

                                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg hover:border-blue-300 cursor-pointer">
                                            <input type="checkbox" name="assistance_types[]" value="medicine" class="mr-3" <?php echo e(in_array('medicine', $assistanceTypes) ? 'checked' : ''); ?>>
                                            <i class="fas fa-pills text-blue-600 mr-2"></i>
                                            <span>Medicine</span>
                                        </label>

                                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg hover:border-blue-300 cursor-pointer">
                                            <input type="checkbox" name="assistance_types[]" value="clothing" class="mr-3" <?php echo e(in_array('clothing', $assistanceTypes) ? 'checked' : ''); ?>>
                                            <i class="fas fa-tshirt text-blue-600 mr-2"></i>
                                            <span>Clothing</span>
                                        </label>

                                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg hover:border-blue-300 cursor-pointer">
                                            <input type="checkbox" name="assistance_types[]" value="shelter" class="mr-3" <?php echo e(in_array('shelter', $assistanceTypes) ? 'checked' : ''); ?>>
                                            <i class="fas fa-home text-blue-600 mr-2"></i>
                                            <span>Shelter</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-align-left mr-2 text-gray-400"></i>Detailed Description
                                    </label>
                                    <textarea name="description" 
                                              rows="4"
                                              required
                                              class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Please provide detailed information about your situation and specific needs..."><?php echo e(old('description', $reliefRequest->description)); ?></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-users mr-2 text-gray-400"></i>Family Members Affected
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">Children (0-12)</label>
                                            <input type="number" name="children_count" min="0" value="<?php echo e(old('children_count', $reliefRequest->children_count)); ?>"
                                                   class="form-input w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">Elderly (60+)</label>
                                            <input type="number" name="elderly_count" min="0" value="<?php echo e(old('elderly_count', $reliefRequest->elderly_count)); ?>"
                                                   class="form-input w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">Persons with Disability</label>
                                            <input type="number" name="pwd_count" min="0" value="<?php echo e(old('pwd_count', $reliefRequest->pwd_count)); ?>"
                                                   class="form-input w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">Pregnant Women</label>
                                            <input type="number" name="pregnant_count" min="0" value="<?php echo e(old('pregnant_count', $reliefRequest->pregnant_count)); ?>"
                                                   class="form-input w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div class="bg-purple-100 rounded-lg p-2 mr-3">
                                    <i class="fas fa-info-circle text-purple-600"></i>
                                </div>
                                Additional Information
                            </h2>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-comment-alt mr-2 text-gray-400"></i>Additional Message
                                    </label>
                                    <textarea name="additional_message" 
                                              rows="3"
                                              class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Any additional information or special requirements..."><?php echo e(old('additional_message', $reliefRequest->additional_message)); ?></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-user-friends mr-2 text-gray-400"></i>Emergency Contact Person
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <input type="text" 
                                               name="emergency_contact_name"
                                               value="<?php echo e(old('emergency_contact_name', $reliefRequest->emergency_contact_name)); ?>"
                                               class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Contact person name">
                                        <input type="tel" 
                                               name="emergency_contact_phone"
                                               value="<?php echo e(old('emergency_contact_phone', $reliefRequest->emergency_contact_phone)); ?>"
                                               class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Contact person phone">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4">
                            <a href="<?php echo e(route('resident.relief-requests.index')); ?>" 
                               class="cancel-btn px-8 py-3 rounded-lg font-semibold"
                               style="background: linear-gradient(135deg, #ef4444, #dc2626) !important; color: white !important; border: 2px solid #ef4444 !important; text-decoration: none; display: inline-flex; align-items: center; padding: 12px 32px;">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                            <button type="submit" 
                                    class="submit-btn px-8 py-3 text-white rounded-lg font-semibold"
                                    style="background: linear-gradient(135deg, #10b981, #059669) !important; color: white !important; border: 2px solid #10b981 !important; display: inline-flex; align-items: center; padding: 12px 32px;">
                                <i class="fas fa-save mr-2"></i>Update Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function toggleCashAmount() {
        const checkbox = document.getElementById('cash_checkbox');
        const container = document.getElementById('cash_amount_container');
        const input = container.querySelector('select');
        
        if (checkbox.checked) {
            container.classList.remove('hidden');
            input.required = true;
        } else {
            container.classList.add('hidden');
            input.required = false;
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.resident', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/resident/relief-requests/edit.blade.php ENDPATH**/ ?>