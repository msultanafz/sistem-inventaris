<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'organization_id',
        'name',
        'code',
        'category',
        'description',
        'quantity',
        'unit',
        'condition',
        'location',
        'purchase_date',
        'notes',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'purchase_date' => 'date', // PASTIKAN BARIS INI ADA DAN BENAR
    ];

    /**
     * Get the organization that owns the inventory item.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the user who created the inventory item.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the inventory item.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the borrowings for the inventory item.
     */
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Check if the item is currently borrowed.
     * An item is considered borrowed if there's any 'borrowed' status transaction for it.
     */
    public function isBorrowed()
    {
        return $this->borrowings()->where('status', 'borrowed')->exists();
    }
}
