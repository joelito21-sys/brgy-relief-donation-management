@extends('layouts.public')

@section('title', 'Privacy Policy')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">Privacy Policy</h1>
                
                <div class="prose max-w-none">
                    <p class="mb-6 text-gray-600">Last updated: {{ now()->format('F j, Y') }}</p>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">1. Information We Collect</h2>
                    <p class="mb-4 text-gray-600">We collect information that you provide directly to us, such as when you make a donation, create an account, or contact us. This may include:</p>
                    <ul class="list-disc pl-5 mb-4 text-gray-600">
                        <li>Personal identification information (name, email address, phone number)</li>
                        <li>Donation details and history</li>
                        <li>Payment information (handled securely by our payment processors)</li>
                        <li>Communication preferences</li>
                    </ul>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">2. How We Use Your Information</h2>
                    <p class="mb-4 text-gray-600">We may use the information we collect for various purposes, including to:</p>
                    <ul class="list-disc pl-5 mb-4 text-gray-600">
                        <li>Process and acknowledge your donations</li>
                        <li>Send you receipts and donation confirmations</li>
                        <li>Improve our services and user experience</li>
                        <li>Communicate with you about our work and how your support helps</li>
                        <li>Comply with legal obligations</li>
                    </ul>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">3. Information Sharing</h2>
                    <p class="mb-4 text-gray-600">We do not sell, trade, or rent your personal information to third parties. We may share information with:</p>
                    <ul class="list-disc pl-5 mb-4 text-gray-600">
                        <li>Service providers who assist with our operations</li>
                        <li>Legal authorities when required by law</li>
                        <li>Other organizations with your consent</li>
                    </ul>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">4. Data Security</h2>
                    <p class="mb-4 text-gray-600">We implement appropriate security measures to protect your personal information. However, no method of transmission over the internet is 100% secure.</p>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">5. Your Rights</h2>
                    <p class="mb-4 text-gray-600">You have the right to:</p>
                    <ul class="list-disc pl-5 mb-4 text-gray-600">
                        <li>Access your personal information</li>
                        <li>Request corrections to your information</li>
                        <li>Request deletion of your information</li>
                        <li>Opt-out of communications</li>
                    </ul>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">6. Changes to This Policy</h2>
                    <p class="mb-4 text-gray-600">We may update this privacy policy from time to time. We will notify you of any changes by posting the new policy on this page.</p>
                    
                    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">7. Contact Us</h2>
                    <p class="mb-4 text-gray-600">If you have any questions about this Privacy Policy, please contact us at <a href="mailto:privacy@floodrelief.ph" class="text-blue-600 hover:text-blue-500">privacy@floodrelief.ph</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection