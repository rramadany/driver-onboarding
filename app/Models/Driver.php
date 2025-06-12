<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\DatabaseNotification;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'license_number',
        'license_expiry_date',
        // The rest were omitted on purpose
    ];

    protected static function booted(): void
    {
        static::deleted(function (Driver $driver) {
            DatabaseNotification::where('data->driver_id', $driver->id)->delete();
        });
    }

    public const FILE_INPUT_MAP = [
        'photo' => [
            'column' => 'photo_path',
            'label' => 'Driver Photo'
        ],
        'gov_id' => [
            'column' => 'doc_gov_id_path',
            'label' => 'Government ID'
        ],
        'residency_card' => [
            'column' => 'doc_residency_card_path',
            'label' => 'Residency Card'
        ],
        'drivers_license' => [
            'column' => 'doc_drivers_license_path',
            'label' => 'Driver\'s License'
        ],
        'non_conviction_certificate' => [
            'column' => 'doc_non_conviction_path',
            'label' => 'Non-Conviction Certificate'
        ],
        'vehicle_registration' => [
            'column' => 'doc_vehicle_reg_path',
            'label' => 'Vehicle Registration'
        ],
    ];


    protected function casts(): array
    {
        return [
            'license_expiry_date' => 'date',
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Maybe I should make policies in the future?
    public function isEditable(): bool
    {
        // let's keep this a stub for now
        return True;
    }

    public function isSubmittable(): bool
    {
        return in_array($this->status, ['draft', 'rejected']);
    }

    public function isReviewable(): bool
    {
        return $this->status === 'pending_approval';
    }
}
