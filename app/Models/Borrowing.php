<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'inventory_item_id',
        'organization_id',
        'borrower_name',
        'borrower_contact',
        'borrower_nim_nip',
        'quantity',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'borrow_photo',
        'return_photo',
        'notes',
        'borrowed_by',
        'returned_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'borrow_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    /**
     * Get the inventory item associated with the borrowing.
     */
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    /**
     * Get the organization that owns the borrowing.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the user who borrowed the item.
     */
    public function borrowedBy()
    {
        return $this->belongsTo(User::class, 'borrowed_by');
    }

    /**
     * Get the user who returned the item.
     */
    public function returnedBy()
    {
        return $this->belongsTo(User::class, 'returned_by');
    }
}