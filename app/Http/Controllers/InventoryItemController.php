<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InventoryItemController extends Controller
{
    // Definisikan kategori dan satuan yang diizinkan sebagai properti statis atau konstanta
    private const CATEGORIES = [
        'Elektronik',
        'Peralatan Laboratorium',
        'Bahan Laboratorium',
        'Furnitur',
        'Alat Tulis',
        'Buku',
        'Lain-lain',
    ];

    private const UNITS = [
        'pcs', 'unit', 'buah', 'set', 'box', 'meter', 'liter', 'roll', 'pack', 'rim',
        'pasang', 'lembar', 'karung', 'kg', 'gram', 'ml', 'botol', 'kaleng', 'tabung',
        'bundel', 'bendel', 'drum', 'palet', 'kodi', 'lusin', 'gross', 'krat',
    ];

    private const CONDITIONS = [
        'Baik', 'Rusak Ringan', 'Rusak Berat', 'Perlu Perbaikan',
    ];

    /**
     * Display a listing of the inventory items for the authenticated organization.
     */
    public function index(Request $request) // Menerima Request untuk parameter pencarian
    {
        $user = Auth::user();
        $organizationId = $user->organization_id;

        if (!$organizationId && !$user->isSuperAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke inventaris organisasi.');
        }

        // Mulai query dengan scope organisasi yang benar
        $query = InventoryItem::query();

        if ($user->isOrganizationAdmin()) {
            $query->where('organization_id', $organizationId);
        }
        
        // Terapkan filter berdasarkan input dari request (ini sudah ada dan tetap dipertahankan)
        if ($request->filled('search_name')) {
            $query->where('name', 'like', '%' . $request->input('search_name') . '%');
        }

        if ($request->filled('search_code')) {
            $query->where('code', 'like', '%' . $request->input('search_code') . '%');
        }

        if ($request->filled('filter_category') && $request->input('filter_category') !== '') {
            $query->where('category', $request->input('filter_category'));
        }

        // Filter kondisi di halaman index utama (ini dikembalikan)
        if ($request->filled('filter_condition') && $request->input('filter_condition') !== '') {
            $query->where('condition', $request->input('filter_condition'));
        }

        if ($request->filled('search_location')) {
            $query->where('location', 'like', '%' . $request->input('search_location') . '%');
        }

        // Urutkan dan paginasi hasilnya
        $items = $query->latest()->paginate(10)->withQueryString();
        
        // Kirimkan juga daftar kategori, satuan, dan kondisi ke view untuk dropdown filter
        $categories = self::CATEGORIES;
        $units = self::UNITS;
        $conditions = self::CONDITIONS; // Pastikan ini dikirim untuk filter kondisi di index

        return view('inventory_items.index', compact('items', 'categories', 'units', 'conditions'));
    }

    /**
     * Show the form for creating a new inventory item.
     */
    public function create()
    {
        $categories = self::CATEGORIES;
        $units = self::UNITS;
        $conditions = self::CONDITIONS;
        return view('inventory_items.create', compact('categories', 'units', 'conditions'));
    }

    /**
     * Store a newly created inventory item in storage.
     */
    public function store(Request $request)
    {
        $organizationId = Auth::user()->organization_id;

        if (!$organizationId) {
            return redirect()->back()->with('error', 'Anda tidak dapat menambahkan barang tanpa organisasi yang terkait.');
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'nullable', 
                'string', 
                'max:255', 
                Rule::unique('inventory_items')->where(function ($query) use ($organizationId) {
                    return $query->where('organization_id', $organizationId);
                }),
            ],
            'category' => ['required', 'string', Rule::in(self::CATEGORIES)],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit' => ['required', 'string', Rule::in(self::UNITS)],
            'condition' => ['required', 'string', Rule::in(self::CONDITIONS)],
            'location' => ['required', 'string', 'max:255'],
            'purchase_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        InventoryItem::create(array_merge($validatedData, [
            'organization_id' => $organizationId,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]));

        return redirect()->route('inventory_items.index')->with('success', 'Barang inventaris berhasil ditambahkan!');
    }

    /**
     * Display the specified inventory item.
     */
    public function show(InventoryItem $inventoryItem)
    {
        if ($inventoryItem->organization_id !== Auth::user()->organization_id && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        return view('inventory_items.show', compact('inventoryItem'));
    }

    /**
     * Show the form for editing the specified inventory item.
     */
    public function edit(InventoryItem $inventoryItem)
    {
        if ($inventoryItem->organization_id !== Auth::user()->organization_id && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        $categories = self::CATEGORIES;
        $units = self::UNITS;
        $conditions = self::CONDITIONS;
        return view('inventory_items.edit', compact('inventoryItem', 'categories', 'units', 'conditions'));
    }

    /**
     * Update the specified inventory item in storage.
     */
    public function update(Request $request, InventoryItem $inventoryItem)
    {
        if ($inventoryItem->organization_id !== Auth::user()->organization_id && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $organizationId = Auth::user()->organization_id;

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'nullable', 
                'string', 
                'max:255', 
                Rule::unique('inventory_items')->where(function ($query) use ($organizationId) {
                    return $query->where('organization_id', $organizationId);
                })->ignore($inventoryItem->id),
            ],
            'category' => ['required', 'string', Rule::in(self::CATEGORIES)],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit' => ['required', 'string', Rule::in(self::UNITS)],
            'condition' => ['required', 'string', Rule::in(self::CONDITIONS)],
            'location' => ['required', 'string', 'max:255'],
            'purchase_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $inventoryItem->update(array_merge($validatedData, ['updated_by' => Auth::id()]));

        return redirect()->route('inventory_items.index')->with('success', 'Barang inventaris berhasil diperbarui!');
    }

    /**
     * Remove the specified inventory item from storage.
     */
    public function destroy(InventoryItem $inventoryItem)
    {
        if ($inventoryItem->organization_id !== Auth::user()->organization_id && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $inventoryItem->delete();
        return redirect()->route('inventory_items.index')->with('success', 'Barang inventaris berhasil dihapus!');
    }

    // Metode byCondition() dihapus dari sini

    /**
     * Display a listing of the most recent inventory items.
     */
    public function recentItems()
    {
        $user = Auth::user();
        $organizationId = $user->organization_id;

        if (!$organizationId && !$user->isSuperAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke inventaris organisasi.');
        }

        $query = InventoryItem::query();

        if ($user->isOrganizationAdmin()) {
            $query->where('organization_id', $organizationId);
        }

        // Ambil 20 barang terbaru (atau jumlah yang Anda inginkan)
        $items = $query->latest()->paginate(5); // Paginasi untuk barang terbaru

        return view('inventory_items.recent_items', compact('items'));
    }
}