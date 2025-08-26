<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    // Tampilkan semua alamat milik user
    public function index()
    {
        $addresses = Auth::user()->addresses()->get();
        return view('customer.addresses', compact('addresses'));
    }

    // Simpan alamat baru
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'nullable|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'note' => 'nullable|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
        ]);

         // ** Tambahkan Logika Pengecekan Nomor Telepon di sini **
        $phone = $request->input('recipient_phone');
            if (str_starts_with($phone, '08')) {
            $phone = '628' . substr($phone, 2);
        }
        // Setel kembali nilai recipient_phone di request
        $request->merge(['recipient_phone' => $phone]);

        $isFirst = Auth::user()->addresses()->count() === 0;
        $address = Auth::user()->addresses()->create([
            'label' => $request->label,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_primary' => $isFirst,
            'note' => $request->note,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
        ]);
        // Redirect berdasarkan field redirect_to atau default ke addresses
        $redirectTo = $request->input('redirect_to', route('addresses'));
        return redirect($redirectTo);
    }

    // Hapus alamat
    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        $address->delete();
        return redirect()->route('addresses')->with('success', 'Alamat berhasil dihapus!');
    }

    // Set alamat utama
    public function setPrimary(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        Auth::user()->addresses()->update(['is_primary' => false]);
        $address->is_primary = true;
        $address->save();
        return redirect()->route('addresses')->with('success', 'Alamat utama berhasil diubah!');
    }

    // Update alamat
    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        $request->validate([
            'label' => 'nullable|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'note' => 'nullable|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
        ]);
        $address->update([
            'label' => $request->label,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'note' => $request->note,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
        ]);
        // Redirect berdasarkan field redirect_to atau default ke addresses
        $redirectTo = $request->input('redirect_to', route('addresses'));
        return redirect($redirectTo);
    }
} 