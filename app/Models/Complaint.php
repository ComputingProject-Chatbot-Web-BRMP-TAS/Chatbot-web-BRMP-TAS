<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    protected $table = 'complaints';
    protected $primaryKey = 'complaint_id';
    protected $fillable = [
        'user_id',
        'transaction_id',
        'nomor_kantong',
        'complaint_types',
        'description',
        'photo_proof',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}