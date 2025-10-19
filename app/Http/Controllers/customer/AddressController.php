<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\AddressService;

class AddressController extends Controller
{
    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }
    // Tampilkan semua alamat milik user
    public function index()
    {
        try {
            $addresses = $this->addressService->getUserAddresses(Auth::user());
            return view('customer.addresses', compact('addresses'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data alamat.');
        }
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

        try {
            // Normalisasi nomor telepon
            $phone = $request->input('recipient_phone');
            if (str_starts_with($phone, '08')) {
                $phone = '628' . substr($phone, 2);
            }

            $data = $request->only([
                'label', 'address', 'latitude', 'longitude', 
                'note', 'recipient_name'
            ]);
            $data['recipient_phone'] = $phone;

            $this->addressService->createAddress(Auth::user(), $data);

            $redirectTo = $request->input('redirect_to', route('addresses'));
            return redirect($redirectTo)->with('success', 'Alamat berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan alamat: ' . $e->getMessage());
        }
    }

    // Hapus alamat
    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            $this->addressService->deleteAddress($address);
            return redirect()->route('addresses')->with('success', 'Alamat berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus alamat: ' . $e->getMessage());
        }
    }

    // Set alamat utama
    public function setPrimary(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            $this->addressService->setPrimaryAddress($address);
            return redirect()->route('addresses')->with('success', 'Alamat utama berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah alamat utama: ' . $e->getMessage());
        }
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

        try {
            // Normalisasi nomor telepon
            $phone = $request->input('recipient_phone');
            if (str_starts_with($phone, '08')) {
                $phone = '628' . substr($phone, 2);
            }

            $data = $request->only([
                'label', 'address', 'latitude', 'longitude', 
                'note', 'recipient_name'
            ]);
            $data['recipient_phone'] = $phone;

            $this->addressService->updateAddress($address, $data);

            $redirectTo = $request->input('redirect_to', route('addresses'));
            return redirect($redirectTo)->with('success', 'Alamat berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui alamat: ' . $e->getMessage());
        }
    }
} 