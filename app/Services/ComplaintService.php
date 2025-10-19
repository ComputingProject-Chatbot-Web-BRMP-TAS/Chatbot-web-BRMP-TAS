<?php

namespace App\Services;

use App\Models\Complaint;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ComplaintService
{
    /**
     * Create new complaint
     */
    public function createComplaint(User $user, array $data, $photoFile)
    {
        try {
            DB::beginTransaction();

            // Validate transaction belongs to user
            $transaction = Transaction::where('transaction_id', $data['transaction_id'])
                ->where('user_id', $user->user_id)
                ->first();

            if (!$transaction) {
                throw new \Exception('Transaksi tidak ditemukan atau bukan milik Anda.');
            }

            // Store photo proof
            $photoPath = $photoFile->store('bukti_komplain', 'public');

            // Create complaint
            $complaint = Complaint::create([
                'user_id' => $user->user_id,
                'transaction_id' => $data['transaction_id'],
                'nomor_kantong' => $data['nomor_kantong'],
                'description' => $data['description'],
                'photo_proof' => $photoPath,
                'status' => 'pending',
                'submitted_at' => now()
            ]);

            Log::info('Complaint created', [
                'complaint_id' => $complaint->id,
                'user_id' => $user->user_id,
                'transaction_id' => $data['transaction_id'],
                'nomor_kantong' => $data['nomor_kantong']
            ]);

            DB::commit();
            return $complaint;

        } catch (\Exception $e) {
            DB::rollback();
            
            // Delete uploaded file if exists
            if (isset($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            Log::error('Failed to create complaint', [
                'user_id' => $user->user_id ?? null,
                'transaction_id' => $data['transaction_id'] ?? null,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get user complaints
     */
    public function getUserComplaints(User $user, $perPage = 10)
    {
        return Complaint::where('user_id', $user->user_id)
            ->with(['transaction'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get complaint details
     */
    public function getComplaintDetails($complaintId, User $user = null)
    {
        $query = Complaint::with(['transaction', 'user']);
        
        if ($user) {
            $query->where('user_id', $user->user_id);
        }
        
        return $query->findOrFail($complaintId);
    }

    /**
     * Update complaint status (Admin only)
     */
    public function updateComplaintStatus(Complaint $complaint, string $status, string $adminResponse = null)
    {
        try {
            DB::beginTransaction();

            $complaint->update([
                'status' => $status,
                'admin_response' => $adminResponse,
                'responded_at' => now()
            ]);

            Log::info('Complaint status updated', [
                'complaint_id' => $complaint->id,
                'new_status' => $status,
                'has_response' => !empty($adminResponse)
            ]);

            DB::commit();
            return $complaint;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update complaint status', [
                'complaint_id' => $complaint->id ?? null,
                'status' => $status ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get all complaints for admin
     */
    public function getAllComplaints($perPage = 15, $status = null)
    {
        $query = Complaint::with(['transaction', 'user'])
            ->orderBy('created_at', 'desc');
            
        if ($status) {
            $query->where('status', $status);
        }
        
        return $query->paginate($perPage);
    }

    /**
     * Get complaint statistics
     */
    public function getComplaintStatistics()
    {
        return [
            'total_complaints' => Complaint::count(),
            'pending_complaints' => Complaint::where('status', 'pending')->count(),
            'resolved_complaints' => Complaint::where('status', 'resolved')->count(),
            'rejected_complaints' => Complaint::where('status', 'rejected')->count(),
            'complaints_today' => Complaint::whereDate('created_at', now())->count(),
            'complaints_this_month' => Complaint::whereMonth('created_at', now()->month)->count(),
        ];
    }

    /**
     * Validate complaint data
     */
    public function validateComplaintData(array $data)
    {
        $requiredFields = ['transaction_id', 'nomor_kantong', 'description'];
        
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new \Exception("Field {$field} is required.");
            }
        }

        if (strlen($data['description']) > 1000) {
            throw new \Exception('Description must be less than 1000 characters.');
        }

        if (!is_numeric($data['nomor_kantong']) || $data['nomor_kantong'] <= 0) {
            throw new \Exception('Nomor kantong must be a positive number.');
        }

        return true;
    }
}