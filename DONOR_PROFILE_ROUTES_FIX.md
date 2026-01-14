# Donor Profile Routes - Fixed

## ✅ Issue Resolved

### **Error:**
```
Route [donor.profile.update] not defined.
```

### **Cause:**
The donor profile routes were incomplete. Only the `GET` route for viewing the profile was defined, but the `PUT` (update) and `DELETE` (destroy) routes were missing.

---

## 🔧 Changes Made

### **1. Added Missing Routes**

**File:** `routes/donor_routes.php`

**Before:**
```php
// Profile
Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
```

**After:**
```php
// Profile
Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
```

### **2. Added Destroy Method to Controller**

**File:** `app/Http/Controllers/Donor/ProfileController.php`

Added the `destroy()` method to handle account deletion:

```php
/**
 * Delete the donor's account.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function destroy(Request $request)
{
    $request->validate([
        'password' => ['required', 'current_password:donor'],
    ]);

    $user = auth()->guard('donor')->user();

    auth()->guard('donor')->logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('donor.login')
        ->with('status', 'Your account has been deleted successfully.');
}
```

---

## 📋 Profile Routes Summary

### **Available Routes:**

| Method | Route | Name | Controller Method | Purpose |
|--------|-------|------|-------------------|---------|
| GET | `/donor/profile` | `donor.profile` | `edit()` | View profile form |
| PUT | `/donor/profile` | `donor.profile.update` | `update()` | Update profile |
| DELETE | `/donor/profile` | `donor.profile.destroy` | `destroy()` | Delete account |

---

## ✨ Features

### **Profile Update:**
- ✅ Update name
- ✅ Update email (with uniqueness check)
- ✅ Update phone
- ✅ Update address
- ✅ Change password (optional)
- ✅ Requires current password for password change

### **Account Deletion:**
- ✅ Requires password confirmation
- ✅ Logs out the user
- ✅ Deletes the account
- ✅ Invalidates session
- ✅ Redirects to login with success message

---

## 🧪 Testing

### **Test Profile Update:**
1. Navigate to `/donor/profile`
2. Update any field
3. Click "Save Changes"
4. ✅ Should update successfully

### **Test Password Change:**
1. Navigate to `/donor/profile`
2. Enter current password
3. Enter new password
4. Confirm new password
5. Click "Save Changes"
6. ✅ Should update password

### **Test Account Deletion:**
1. Navigate to `/donor/profile`
2. Scroll to "Delete Account" section
3. Enter password
4. Click "Delete Account"
5. ✅ Should delete account and redirect to login

---

## 🔒 Security Features

### **Update Method:**
- ✅ Validates all input
- ✅ Checks email uniqueness (excluding current user)
- ✅ Requires current password for password change
- ✅ Uses `current_password:donor` validation rule
- ✅ Hashes new password with `Hash::make()`

### **Destroy Method:**
- ✅ Requires password confirmation
- ✅ Uses `current_password:donor` validation
- ✅ Logs out before deletion
- ✅ Invalidates session
- ✅ Regenerates CSRF token

---

## 📁 Files Modified

1. **`routes/donor_routes.php`**
   - Added `profile.update` route (PUT)
   - Added `profile.destroy` route (DELETE)

2. **`app/Http/Controllers/Donor/ProfileController.php`**
   - Added `destroy()` method

---

## 🚀 Cache Cleared

- ✅ Route cache cleared (`php artisan route:clear`)
- ✅ Config cache cleared (`php artisan config:clear`)

---

## ✅ Status

**FIXED** - The donor profile page should now work correctly!

The error `Route [donor.profile.update] not defined` has been resolved.

---

**Last Updated:** 2025-12-13 20:32 PM
**Issue:** Route not defined
**Resolution:** Added missing routes and controller method
