<?php

namespace App\Services;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;

class StudentService
{
    public function saveStudentAndParent(array $data, bool $isEnrollment = false)
    {
        DB::beginTransaction();

        try {
            // Handle student profile picture if provided
            $photoPath = $data['student_photo'] ?? null;

            // Create student user account
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['student_email'],
                'contact_number' => $data['student_phone_number'],
                'name' => $data['firstname'] . ' ' . $data['lastname'],
                'password' => Hash::make('gva-student'),
                'role_id' => 3, // Student role ID
                'profile_picture' => $photoPath,
                'status' => 1,
            ]);

            // Create student record
            $student = Student::create([
                'user_id' => $user->id,
                'ecz_no' => $data['ecz_no'],
                'class_id' => $data['class_id'],
                'student_type' => $data['student_type'],
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'gender' => $data['gender'],
                'dob' => $data['dob'],
                'admission_date' => $isEnrollment ? null : $data['admission_date'],
                'religion' => $data['religion'] ?? null,
                'nrc_id_no' => $data['nrc_id_no'] ?? null,
                'medical_condition' => $data['medical_condition'] ?? null,
                'bedspace_id' => $data['bedspace_id'] ?? null,
                'hostel_id' => $data['hostel_id'] ?? null,
                'student_photo' => $photoPath,
            ]);


            

            // Other logic like bedspace handling, guardian creation, fees, etc.
            if (!$isEnrollment) {
                // Handle additional logic for full registration here
            }

            DB::commit();
            return $student;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
