<?php

namespace App\Services;

use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddressService
{
    /**
     * Create new address for user
     */
    public function createAddress(User $user, array $data)
    {
        try {
            DB::beginTransaction();

            // If this is the first address or set as primary, make it primary
            $userAddressCount = Address::where('user_id', $user->user_id)->count();
            if ($userAddressCount === 0 || (isset($data['is_primary']) && $data['is_primary'])) {
                // Remove primary status from other addresses
                Address::where('user_id', $user->user_id)->update(['is_primary' => false]);
                $data['is_primary'] = true;
            }

            $data['user_id'] = $user->user_id;
            $address = Address::create($data);

            Log::info('Address created', [
                'user_id' => $user->user_id,
                'address_id' => $address->address_id,
                'is_primary' => $address->is_primary
            ]);

            DB::commit();
            return $address;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create address', [
                'user_id' => $user->user_id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Update address with validation
     */
    public function updateAddress(Address $address, array $data)
    {
        try {
            DB::beginTransaction();

            // Handle primary address change
            if (isset($data['is_primary']) && $data['is_primary'] && !$address->is_primary) {
                // Remove primary status from other addresses
                Address::where('user_id', $address->user_id)
                    ->where('address_id', '!=', $address->address_id)
                    ->update(['is_primary' => false]);
            }

            $address->update($data);

            Log::info('Address updated', [
                'user_id' => $address->user_id,
                'address_id' => $address->address_id,
                'updated_fields' => array_keys($data)
            ]);

            DB::commit();
            return $address;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update address', [
                'address_id' => $address->address_id ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Delete address safely
     */
    public function deleteAddress(Address $address)
    {
        try {
            DB::beginTransaction();

            $userId = $address->user_id;
            $wasPrimary = $address->is_primary;

            $address->delete();

            // If deleted address was primary, set another address as primary
            if ($wasPrimary) {
                $nextAddress = Address::where('user_id', $userId)->first();
                if ($nextAddress) {
                    $nextAddress->update(['is_primary' => true]);
                    
                    Log::info('Primary address reassigned', [
                        'user_id' => $userId,
                        'new_primary_address_id' => $nextAddress->address_id
                    ]);
                }
            }

            Log::info('Address deleted', [
                'user_id' => $userId,
                'address_id' => $address->address_id,
                'was_primary' => $wasPrimary
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to delete address', [
                'address_id' => $address->address_id ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Set address as primary
     */
    public function setPrimaryAddress(Address $address)
    {
        try {
            DB::beginTransaction();

            // Remove primary status from other addresses
            Address::where('user_id', $address->user_id)
                ->where('address_id', '!=', $address->address_id)
                ->update(['is_primary' => false]);

            // Set this address as primary
            $address->update(['is_primary' => true]);

            Log::info('Primary address changed', [
                'user_id' => $address->user_id,
                'new_primary_address_id' => $address->address_id
            ]);

            DB::commit();
            return $address;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to set primary address', [
                'address_id' => $address->address_id ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get user addresses with primary first
     */
    public function getUserAddresses(User $user)
    {
        return Address::where('user_id', $user->user_id)
            ->orderBy('is_primary', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get primary address for user
     */
    public function getPrimaryAddress(User $user)
    {
        return Address::where('user_id', $user->user_id)
            ->where('is_primary', true)
            ->first();
    }

    /**
     * Validate address completeness
     */
    public function validateAddressCompleteness(array $data)
    {
        $requiredFields = [
            'recipient_name',
            'recipient_phone',
            'address',
            'postal_code'
        ];

        $missingFields = [];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            throw new \Exception('Data alamat tidak lengkap: ' . implode(', ', $missingFields));
        }

        return true;
    }

    /**
     * Format address for display
     */
    public function formatAddress(Address $address)
    {
        $formatted = $address->recipient_name . "\n";
        $formatted .= $address->recipient_phone . "\n";
        $formatted .= $address->address . "\n";
        
        if ($address->subdistrict) {
            $formatted .= $address->subdistrict . ", ";
        }
        
        if ($address->regency) {
            $formatted .= $address->regency . ", ";
        }
        
        if ($address->province) {
            $formatted .= $address->province . " ";
        }
        
        $formatted .= $address->postal_code;

        if ($address->note) {
            $formatted .= "\nCatatan: " . $address->note;
        }

        return $formatted;
    }

    /**
     * Get address statistics for admin
     */
    public function getAddressStatistics()
    {
        return [
            'total_addresses' => Address::count(),
            'users_with_addresses' => Address::distinct('user_id')->count(),
            'users_without_addresses' => User::whereDoesntHave('addresses')->count(),
            'recent_addresses' => Address::whereDate('created_at', '>=', now()->subDays(7))->count(),
        ];
    }
}