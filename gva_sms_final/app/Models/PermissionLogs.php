<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionLogs extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'permission_logs';

    // Mass assignable attributes
    protected $fillable = [
        'permission_id',
        'student_id',
        'staff_id',
        'role_name',
        'permission_status',
    ];

    const STATUS_PERMISSION_GRANTED = 'permission_granted';
    const STATUS_PERMISSION_REJECTED = 'permission_rejected';
    const STATUS_PERMISSION_PENDING = 'permission_pending';
    const STATUS_PERMISSION_EXPIRED = 'permission_expired';
    const STATUS_PERMISSION_WITHDRAWN = 'permission_withdrawn';
    const STATUS_PERMISSION_CANCELLED = 'permission_cancelled';

    /**
     * Relationships
     */

    // Permission relationship
    public function permission()
    {
        return $this->belongsTo(StudentHomePermission::class, 'permission_id', 'id');
    }

    // Student relationship
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    // Staff relationship
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
}
