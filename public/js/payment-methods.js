document.addEventListener('DOMContentLoaded', function() {
    // Get all payment method radio buttons
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    
    // Function to show the selected payment method details
    function showSelectedPayment() {
        // Hide all payment details first
        document.querySelectorAll('.payment-details').forEach(detail => {
            detail.classList.add('hidden');
        });
        
        // Show the selected payment method details
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
        if (selectedMethod) {
            const detailsId = selectedMethod.id + '-details';
            const detailsElement = document.getElementById(detailsId);
            if (detailsElement) {
                detailsElement.classList.remove('hidden');
            }
        }
    }
    
    // Add event listeners to all payment method radio buttons
    paymentMethods.forEach(method => {
        method.addEventListener('change', showSelectedPayment);
    });
    
    // Initialize the view
    showSelectedPayment();
    
    // Handle donation amount buttons
    const amountButtons = document.querySelectorAll('.donation-amount-btn');
    const customAmountInput = document.getElementById('custom-amount');
    
    amountButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            amountButtons.forEach(btn => {
                btn.classList.remove('border-indigo-500', 'bg-indigo-50');
                btn.classList.add('border-gray-200', 'bg-gray-100');
            });
            
            // Add active class to clicked button
            this.classList.remove('border-gray-200', 'bg-gray-100');
            this.classList.add('border-indigo-500', 'bg-indigo-50');
            
            // Update the custom amount input
            const amount = this.querySelector('.font-bold').textContent.replace(/[^0-9.]/g, '');
            customAmountInput.value = amount;
        });
    });
    
    // Handle custom amount input
    customAmountInput.addEventListener('focus', function() {
        // Remove active class from all amount buttons
        amountButtons.forEach(btn => {
            btn.classList.remove('border-indigo-500', 'bg-indigo-50');
            btn.classList.add('border-gray-200', 'bg-gray-100');
        });
    });
});
