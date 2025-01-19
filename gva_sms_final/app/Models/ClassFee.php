<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassFee extends Model
{
    use HasFactory;

    protected $table = 'class_fees'; // The table name is "class_fees"

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fee_category_id',
        'class_id',
        'academic_year_id',
        'term_no',
        'amount',
    ];

    /**
     * Define the relationship with the FeeCategory model.
     */
    public function feeCategory()
    {
        return $this->belongsTo(FeeCatergories::class, 'fee_category_id');
    }

    /**
     * Define the relationship with the Grade model.
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'class_id');
    }

    /**
     * Define the relationship with the AcademicSession model.
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id');
    }

    /**
     * Scope a query to filter by term number.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $termNo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByTerm($query, $termNo)
    {
        return $query->where('term_no', $termNo);
    }

    /**
     * Scope a query to filter by student type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $studentType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStudentType($query, $studentType)
    {
        return $query->where('student_type', $studentType);
    }
}
