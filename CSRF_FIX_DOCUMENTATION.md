# CSRF "Page Expired" Error - Fixed

## Problem
When clicking "Set Amount" with value 419 (or any value), you were getting a "Page Expired" error. This is a **CSRF token expiration** issue in Laravel.

## Root Cause
The CSRF (Cross-Site Request Forgery) token expires when:
1. The page has been open for too long (session timeout)
2. The user is idle for extended periods
3. The session expires (default: 120 minutes)

## Solution Implemented

### 1. **Automatic CSRF Token Refresh** ✅
I've added JavaScript to the GCash payment page that:
- **Automatically refreshes the CSRF token every 30 minutes**
- **Prevents token expiration** while the page is open
- **Updates all form tokens** on the page

### 2. **Automatic Retry on 419 Error** ✅
The form now:
- **Detects 419 errors** (Page Expired)
- **Automatically refreshes the token**
- **Retries the request** without user intervention
- **Shows "Processing..." feedback** during submission

### 3. **User-Friendly Error Handling** ✅
If an error occurs:
- The submit button is re-enabled
- An alert notifies the user
- The form can be resubmitted

## What Changed

### File: `gcash.blade.php`
Added comprehensive JavaScript that:
1. Refreshes CSRF tokens periodically
2. Handles form submission via AJAX
3. Automatically retries on CSRF errors
4. Provides visual feedback

## Testing the Fix

### Test Case 1: Normal Submission
1. Enter an amount (e.g., 419)
2. Click "Set Amount"
3. ✅ Should work immediately without errors

### Test Case 2: After Long Idle Time
1. Open the payment page
2. Wait 30+ minutes
3. Enter an amount
4. Click "Set Amount"
5. ✅ Should automatically refresh token and submit successfully

### Test Case 3: Expired Session
1. Open the payment page
2. Clear browser cookies/session
3. Enter an amount
4. Click "Set Amount"
5. ✅ Should attempt to refresh and handle gracefully

## Additional Recommendations

### Option 1: Increase Session Lifetime (Optional)
If you want to extend the session timeout beyond 2 hours:

**File:** `.env`
```env
SESSION_LIFETIME=480  # 8 hours (in minutes)
```

### Option 2: Apply to Other Payment Methods
The same fix should be applied to:
- PayMaya payment page
- Bank transfer payment page

Would you like me to apply this fix to those pages as well?

### Option 3: Clear Application Cache
After making changes, run:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## How It Works

### Before (Old Behavior):
```
User opens page → Token generated → User waits → Token expires → Submit form → ❌ 419 Error
```

### After (New Behavior):
```
User opens page → Token generated → Auto-refresh every 30min → Submit form → ✅ Success
                                                                    ↓ (if 419)
                                                            Refresh token → Retry → ✅ Success
```

## Technical Details

### CSRF Token Refresh Function
```javascript
function refreshCsrfToken() {
    // Fetches a fresh page to get new CSRF token
    // Updates meta tag and all form inputs
    // Runs every 30 minutes automatically
}
```

### Form Submission Handler
```javascript
// Intercepts form submission
// Sends via AJAX
// Detects 419 errors
// Auto-refreshes token and retries
// Provides user feedback
```

## Status
✅ **FIXED** - The "Page Expired" error should no longer occur when setting donation amounts.

## Next Steps
1. Test the fix by entering an amount and clicking "Set Amount"
2. If you want the same fix on PayMaya and Bank pages, let me know
3. Consider increasing SESSION_LIFETIME if users frequently have long idle times

---
**Last Updated:** 2025-12-13
**Files Modified:** `gcash.blade.php`
