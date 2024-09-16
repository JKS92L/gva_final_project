<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\User;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $roles = [
            // 'system admin', //active
            'admin', //active
            'teacher', //active
            'student', //active
            'class teacher', //active
            'parent', //active
            'librarian',
            'shopkeeper',
            'nurse',
            'maintance',
            'patron-matron', //active
            'boarding teacher',
            'head of department',
            'CPD coordinator',
            'alumni'
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }


        $permissions = [
            //user management
            'view user list',
            'add new user',
            'assign responibility',
            'view roles',
            'add new role',
            'edit role',
            'delete roles',

            //Teacher Management module
            'assign subject',
            'observe teacher',
            'Appraise teacher',
            'monitor file',
            'Assign responsibilities',
            'view CPD report',
            'view teachers report',
            'view communication log',

            // student management module
            'view student details',
            'edit student details',
            'update student details',
            'view student admission',
            'admit new student',
            'view online admission',
            'disable Students',
            'Bulk Delete',
            'manage student categories',
            'mark Student Register',
            'update student register',

            //CPD Module
            'Manage CPD meetings',
            'view Upcoming Meetings',
            'view CPD Reports',
            'manage CPD Resources',
            'view feedback and evaluation',
            'view CPD Calendar',
            'manage CPD Calendar',
            'view CPD Attendance Reports',
            'Set CPD Goals',
            'create CPD Budget',

            // Academics
            'view class timetable',
            'mark period Register',
            'view teachers timetable',
            'assign Class Teacher',
            'promote Students',
            'view subjects',
            'create subjects',
            'view class list',

            //Homework menu
            'Add Homework',
            'View Homework',
            'Evaluate Homework',
            'View Evaluation Report',

            //Sickbay
            'prescribe Medication',
            'issue Medication',
            'view medical Reports',
            'manage -Recommend Actions',
            'view patient history',

            //Library
            'manage Books',
            'issue Return',
            'issue Books',

            //Departments
            'departmental plans',
            'assign roles',
            'departmental list',
            'departmental inventory',


            //Committee
            'prepare budget',
            'send budget',
            'committee structure',
            'view meeting minutes',
            'task assignment',

            //Human Resource
            'manage staff directory',
            'manage staff attendance',
            'send leave request',
            'view leave request',
            'manage payroll',
            'view payroll reports',
            'send bulk payslips',
            'view HR Reports',
            'manage-management roles',

            // Hostel
            'Manage hostel rooms',
            'Manage hostel members',
            'view Hostel reports',
            'view hostel list',

            // Attendance Register
            'mark student attendance',
            'approve Permission',
            'request Permission',
            'view attendance By Report',

            //alumni
            'maanage Alumni list',
            'create events',
            'view events',
            'Alumni list',
            'Add alumni',
            'alumni reports',

            //Behaviour Records
            'assign incident',
            'view school rules',
            'view disciplary appeal',
            'send disciplanry appeal',
            'view appeal responses',
            'view incidents',
            'view Reports',
            'manage disciplanry Setting',

            //Examination 
            'Publish Results',
            'View Results',
            'View Results Queries',
            'Enter Results',
            'View Past Papers',
            'Upload to Question Bank',
            'View Exam Timetables',
            'view Pupils Performance Report',
            'view Grading System',
            'Generate Report Card',
            'View Exam Analysis',

            //  Settings
            'Manage General Settings',
            'Manage Session Settings',
            'Manage Notification Settings',
            'Manage SMS Settings',
            'Manage Email Settings',
            'Manage Payment Methods',
            'Print Header Footer',
            'Manage Front CMS Settings',
            'Manage Roles Permissions',
            'Backup Restore',
            'Manage Languages',
            'Manage Currency',
            'Manage Users',
            'Manage Modules',
            'Custom Fields'

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(Permission::all());

        $teacherRole = Role::findByName('teacher');
        $teacherRole->givePermissionTo([
            'observe teacher',
            'view CPD report',
            'view student details',
            'view CPD Calendar',
            'view Upcoming Meetings',
            'view CPD Attendance Reports',
            'Add Homework',
            'Evaluate Homework',
            'View Evaluation Report',
            'view school rules',
            'view incidents',
            'View Results',
            'View Results Queries',
            'Enter Results',
            'View Past Papers',
            'Upload to Question Bank',
            'View Exam Timetables',
            'view Pupils Performance Report',
            'view Grading System',
            'View Exam Analysis'
        ]);

        //student roles
        $studentRole = Role::findByName('student');
        $studentRole->givePermissionTo([
            // Academics
            'view class timetable',
            'view class list',
            'view subjects',
            'View Evaluation Report',
            // Attendance Register
            'view attendance By Report',
            //Examination
            'View Results',
            'View Past Papers',
            'View Exam Timetables',
            'view Pupils Performance Report',
            'view Grading System'

        ]);
        //parent roles
        $parenttRole = Role::findByName('parent');
        $parenttRole->givePermissionTo([
            // Academics
            'view class timetable',
            'view class list',
            'view subjects',
            'View Evaluation Report',
            //Sickbay
            'view medical Reports',
            // Attendance Register
            'view attendance By Report',
            'request Permission',
            //Examination
            'View Results',
            'View Past Papers',
            'View Exam Timetables',
            'view Pupils Performance Report',
            'view Grading System'

        ]);
        // Class teacher
        $classTeachertRole = Role::findByName('class teacher');
        $classTeachertRole->givePermissionTo([
            'observe teacher',
            'view CPD report',
            'view student details',
            'view CPD Calendar',

            // Attendance Register
            'mark student attendance',
            'view Upcoming Meetings',
            'view CPD Attendance Reports',
            'Add Homework',
            'Evaluate Homework',
            'View Evaluation Report',
            'view school rules',
            'view incidents',
            'View Results',
            'View Results Queries',
            'Enter Results',
            'View Past Papers',
            'Upload to Question Bank',
            'View Exam Timetables',
            'view Pupils Performance Report',
            'view Grading System',
            'View Exam Analysis'
        ]);

        //matron-patron roles
        $matronParontRole = Role::findByName('patron-matron');
        $matronParontRole->givePermissionTo([
            'observe teacher',
            'view CPD report',
            'view student details',
            'view CPD Calendar',

            // Attendance Register
            'view Upcoming Meetings',
            'view CPD Attendance Reports',
            'Add Homework',
            'Evaluate Homework',
            'View Evaluation Report',
            'view school rules',
            'view incidents',
            'View Results',
            'View Results Queries',
            'Enter Results',
            'View Past Papers',
            'Upload to Question Bank',
            'View Exam Timetables',
            'view Pupils Performance Report',
            'view Grading System',
            'View Exam Analysis',

            // Hostel
            'Manage hostel rooms',
            'Manage hostel members',
            'view Hostel reports',
            'view hostel list',

        ]);

        // Assign roles to users
        $admin = User::where('email', 'admin@example.com')->first(); // Replace with actual admin email
        $admin->assignRole($adminRole);

       
    }

}
