@extends('layouts.public')

@section('title', 'Terms of Service')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">Terms of Service</h1>
                
                <div class="prose max-w-none">
                    <p class="mb-6 text-gray-600">Last updated: {{ now()->format('F j, Y') }}</p>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">1. Acceptance of Terms</h2>
                    <p class="mb-4 text-gray-600">By accessing and using the Barangay Cubacub Relief and Donation Management Program platform, you accept and agree to be bound by the terms and conditions set forth in this agreement.</p>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">2. Donations</h2>
                    <p class="mb-4 text-gray-600">All donations made through our platform are final and non-refundable. We reserve the right to refuse or return any donation at our discretion.</p>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">3. Use of Donations</h2>
                    <p class="mb-4 text-gray-600">We make every effort to ensure that donations are used for their intended purposes. However, we reserve the right to allocate funds where they are needed most in the event of changing circumstances.</p>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">4. Privacy</h2>
                    <p class="mb-4 text-gray-600">We respect your privacy and are committed to protecting your personal information. Please refer to our Privacy Policy for details on how we collect, use, and protect your data.</p>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">5. Limitation of Liability</h2>
                    <p class="mb-4 text-gray-600">Barangay Cubacub Relief and Donation Management Program shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of or inability to use the platform.</p>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">6. Changes to Terms</h2>
                    <p class="mb-4 text-gray-600">We reserve the right to modify these terms at any time. Your continued use of the platform after such changes constitutes your acceptance of the new terms.</p>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">7. Contact Information</h2>
                    <p class="mb-4 text-gray-600">If you have any questions about these terms, please contact us at <a href="mailto:support@floodrelief.ph" class="text-blue-600 hover:text-blue-500">support@floodrelief.ph</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection