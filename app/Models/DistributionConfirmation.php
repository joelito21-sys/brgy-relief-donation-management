<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class DistributionConfirmation extends Model
{
    protected $fillable = [
        'distribution_notification_id',
        'resident_id',
        'qr_code',
        'confirmed_at',
        'confirmed_by',
        'notes',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($confirmation) {
            if (empty($confirmation->qr_code)) {
                $confirmation->qr_code = static::generateUniqueQrCode();
            }
        });
    }

    /**
     * Generate a unique QR code token.
     */
    public static function generateUniqueQrCode(): string
    {
        do {
            $code = 'DIST-' . strtoupper(Str::random(12));
        } while (static::where('qr_code', $code)->exists());

        return $code;
    }

    /**
     * Get the distribution notification.
     */
    public function distributionNotification(): BelongsTo
    {
        return $this->belongsTo(DistributionNotification::class);
    }

    /**
     * Get the resident.
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * Get the admin who confirmed.
     */
    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'confirmed_by');
    }

    /**
     * Check if this confirmation has been confirmed.
     */
    public function isConfirmed(): bool
    {
        return $this->confirmed_at !== null;
    }

    /**
     * Mark as confirmed.
     */
    public function confirm(int $adminId, ?string $notes = null): bool
    {
        return $this->update([
            'confirmed_at' => now(),
            'confirmed_by' => $adminId,
            'notes' => $notes,
        ]);
    }

    /**
     * Generate QR code image as base64.
     */
    public function getQrCodeImageAttribute(): string
    {
        $options = new \chillerlan\QRCode\QROptions([
            'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => \chillerlan\QRCode\QRCode::ECC_L,
            'scale' => 5,
        ]);

        $qrcode = new \chillerlan\QRCode\QRCode($options);
        return $qrcode->render($this->qr_code);
    }

    /**
     * Get the verification URL for this QR code.
     */
    public function getVerificationUrlAttribute(): string
    {
        return route('admin.scanner.verify', $this->qr_code);
    }
}
