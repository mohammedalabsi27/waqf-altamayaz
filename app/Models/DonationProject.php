<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class DonationProject extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'target_amount',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'target_amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (DonationProject $project) {
            if (empty($project->slug)) {
                // الأسماء العربية فقط تُنتج slug فارغاً، لذا نستخدم بديلاً عشوائياً
                $project->slug = Str::slug($project->name) ?: Str::lower(Str::random(8));
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function confirmedDonations(): HasMany
    {
        return $this->hasMany(Donation::class)->confirmed();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /** المبلغ المحصَّل (التبرعات المؤكدة فقط) — يستفيد من withSum إن وُجد */
    public function getRaisedAmountAttribute(): float
    {
        return (float) ($this->attributes['confirmed_donations_sum_amount']
            ?? $this->confirmedDonations()->sum('amount'));
    }

    /** نسبة الإنجاز من المستهدف (0-100) */
    public function getProgressPercentAttribute(): int
    {
        if ((float) $this->target_amount <= 0) {
            return 0;
        }

        return (int) min(100, round($this->raised_amount / (float) $this->target_amount * 100));
    }
}
