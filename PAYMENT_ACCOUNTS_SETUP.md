# Payment Account Configuration Guide

## How to Update Your Payment Account Details

Your GCash, PayMaya, and Bank account details are displayed to donors during the payment process. Follow these steps to update them:

### Option 1: Update via .env File (Recommended)

1. Open your `.env` file in the root directory
2. Add the following lines at the end of the file:

```env
# Payment Account Configuration
GCASH_NUMBER="09171234567"
GCASH_ACCOUNT_NAME="Barangay Cubacub Relief Fund"

PAYMAYA_NUMBER="09181234567"
PAYMAYA_ACCOUNT_NAME="Barangay Cubacub Relief Fund"

BPI_ACCOUNT_NAME="Barangay Cubacub Relief Fund"
BPI_ACCOUNT_NUMBER="1234 5678 9012"
BPI_BRANCH="BPI Cubacub Branch"

BDO_ACCOUNT_NAME="Barangay Cubacub Relief Fund"
BDO_ACCOUNT_NUMBER="9876 5432 1098"
BDO_BRANCH="BDO Cubacub Branch"

METROBANK_ACCOUNT_NAME="Barangay Cubacub Relief Fund"
METROBANK_ACCOUNT_NUMBER="5678 1234 5678"
METROBANK_BRANCH="Metrobank Cubacub Branch"
```

3. Replace the placeholder values with your actual account details
4. Save the file
5. Clear the config cache: `php artisan config:clear`

### Option 2: Update via Config File

1. Open `config/payment_accounts.php`
2. Update the default values directly in the file
3. Save the file

### Where These Details Appear

- **GCash Page**: Donors see your GCash number when selecting GCash payment
- **PayMaya Page**: Donors see your PayMaya number when selecting PayMaya payment
- **Bank Page**: Donors see all three bank accounts (BPI, BDO, Metrobank) with account numbers and branches
- **Payment Gateway**: The account details also appear in the simulated payment gateway pages

### Security Note

- Never commit your `.env` file to version control
- The `.env` file is already in `.gitignore` for your protection
- Only share account details with trusted team members

### Testing

After updating the details:
1. Log in as a donor
2. Go to "Donate Now"
3. Select a payment method (GCash, PayMaya, or Bank)
4. Verify that your actual account details are displayed

---

**Need Help?**
If you encounter any issues, contact your system administrator.
