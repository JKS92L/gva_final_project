<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Submenu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Define menus and their submenus
        $menus = [
            // User Management
            [
                'text' => 'User Management',
                'icon' => 'fas fa-users-cog',
                'submenus' => [
                    ['text' => 'User List'],
                    ['text' => 'User Responsibilities'],
                    ['text' => 'User Permissions'],
                ],
            ],
            // Teacher Management
            [
                'text' => 'Teacher Management',
                'icon' => 'fas fa-chalkboard-teacher',
                'submenus' => [
                    ['text' => 'Assign Subject'],
                    ['text' => 'Lesson Observation'],
                    ['text' => 'File Monitoring'],
                    ['text' => 'Teacher Appraisal'],
                    ['text' => 'Assign Responsibility'],
                    ['text' => 'CPD Report'],
                    ['text' => 'Teacher Timetable'],
                    ['text' => 'Teacher Reports'],
                    ['text' => 'Communication Logs'],
                ],
            ],
            // Student Information
            [
                'text' => 'Student Information',
                'icon' => 'fas fa-user-graduate',
                'submenus' => [
                    ['text' => 'Student Details'],
                    ['text' => 'Student Admission'],
                    ['text' => 'Online Admission'],
                    ['text' => 'Disable Students'],
                    ['text' => 'Bulk Delete'],
                    ['text' => 'Student Categories'],
                    ['text' => 'Student Register'],
                    ['text' => 'Disable Reason'],
                ],
            ],
            // Attendance Register
            [
                'text' => 'Attendance Register',
                'icon' => 'fas fa-calendar-check',
                'submenus' => [
                    ['text' => 'View Student Attendance'],
                    ['text' => 'Approve Permission'],
                    ['text' => 'Request Permission'],
                    ['text' => 'Attendance By Report'],
                ],
            ],
            // CPD Meetings
            [
                'text' => 'CPD Meetings',
                'icon' => 'fas fa-calendar-check',
                'submenus' => [
                    ['text' => 'Schedule CPD Meetings'],
                    ['text' => 'View Upcoming Meetings'],
                    ['text' => 'Manage CPD Calendar'],
                    ['text' => 'View CPD Calendar'],
                    ['text' => 'CPD Meeting Reports'],
                    ['text' => 'CPD Resources'],
                    ['text' => 'Feedback and Evaluation'],
                    ['text' => 'CPD Attendance Reports'],
                    ['text' => 'Set CPD Goals'],
                    ['text' => 'CPD Budget'],
                ],
            ],
            // Academics
            [
                'text' => 'Academics',
                'icon' => 'fas fa-book',
                'submenus' => [
                    ['text' => 'Class Timetable'],
                    ['text' => 'Period Register'],
                    ['text' => 'Teachers Timetable'],
                    ['text' => 'Assign Class Teacher'],
                    ['text' => 'Promote Students'],
                    ['text' => 'Subjects List'],
                    ['text' => 'Create Subjects'],
                    ['text' => 'Class Lists'],
                ],
            ],
            // Homework
            [
                'text' => 'Homework',
                'icon' => 'fas fa-book-open',
                'submenus' => [
                    ['text' => 'Add Homework'],
                    ['text' => 'Homework Evaluation'],
                    ['text' => 'Evaluation Report'],
                ],
            ],
            // Sickbay
            [
                'text' => 'Sickbay',
                'icon' => 'fas fa-medkit',
                'submenus' => [
                    ['text' => 'Prescribe Medication'],
                    ['text' => 'Issue Medication'],
                    ['text' => 'Medical Reports'],
                    ['text' => 'Recommend Actions'],
                    ['text' => 'Patient History'],
                ],
            ],
            // Library
            [
                'text' => 'Library',
                'icon' => 'fas fa-book-reader',
                'submenus' => [
                    ['text' => 'Books'],
                    ['text' => 'Issue Return'],
                    ['text' => 'Issue Books'],
                    ['text' => 'Add Books'],
                ],
            ],
            // Sports
            [
                'text' => 'Sports',
                'icon' => 'fas fa-futbol',
                'submenus' => [
                    ['text' => 'Teams'],
                    ['text' => 'Events'],
                    ['text' => 'Tournaments'],
                    ['text' => 'Coaches'],
                    ['text' => 'Athlete Management'],
                ],
            ],
            // Clubs
            [
                'text' => 'Clubs',
                'icon' => 'fas fa-users',
                'submenus' => [
                    ['text' => 'Club List'],
                    ['text' => 'Club Events'],
                    ['text' => 'Membership Management'],
                    ['text' => 'Club Leaders'],
                    ['text' => 'Budget and Finance'],
                ],
            ],
            // Alumni
            [
                'text' => 'Alumni',
                'icon' => 'fas fa-user-graduate',
                'submenus' => [
                    ['text' => 'Manage Alumni'],
                    ['text' => 'View Events'],
                    ['text' => 'Create Events'],
                    ['text' => 'Alumni List'],
                    ['text' => 'Add Alumni'],
                    ['text' => 'Alumni Reports'],
                ],
            ],
            // Departments
            [
                'text' => 'Departments',
                'icon' => 'fas fa-building',
                'submenus' => [
                    ['text' => 'Departmental Plans'],
                    ['text' => 'Assign Roles'],
                    ['text' => 'Departmental List'],
                    ['text' => 'Departmental Inventory'],
                ],
            ],
            // Committee
            [
                'text' => 'Committee',
                'icon' => 'fas fa-users-cog',
                'submenus' => [
                    ['text' => 'Prepare Budget'],
                    ['text' => 'Send Budget'],
                    ['text' => 'Committee Structure'],
                    ['text' => 'Meeting Minutes'],
                    ['text' => 'Task Assignment'],
                ],
            ],
            // Human Resource
            [
                'text' => 'Human Resource',
                'icon' => 'fas fa-users',
                'submenus' => [
                    ['text' => 'Staff Directory'],
                    ['text' => 'Staff Attendance'],
                    ['text' => 'View Leave Request'],
                    ['text' => 'Send Leave Request'],
                    ['text' => 'Payroll'],
                    ['text' => 'View Payslip'],
                    ['text' => 'Send Bulk Payslips'],
                    ['text' => 'Payroll Reports'],
                    ['text' => 'Pay Slip'],
                    ['text' => 'HR Reports'],
                    ['text' => 'Management Roles'],
                ],
            ],
            // Hostel
            [
                'text' => 'Hostel',
                'icon' => 'fas fa-bed',
                'submenus' => [
                    ['text' => 'Hostel Rooms'],
                    ['text' => 'Hostel Members'],
                    ['text' => 'Hostel Reports'],
                    ['text' => 'Hostel List'],
                ],
            ],
            // Behaviour Records
            [
                'text' => 'Behaviour Records',
                'icon' => 'fas fa-gavel',
                'submenus' => [
                    ['text' => 'Assign Incident'],
                    ['text' => 'Send Appeal'],
                    ['text' => 'View Appeal Responses'],
                    ['text' => 'View Appeals'],
                    ['text' => 'Incidents'],
                    ['text' => 'Reports'],
                    ['text' => 'Setting'],
                ],
            ],
            // Certificate
            [
                'text' => 'Certificate',
                'icon' => 'fas fa-certificate',
                'submenus' => [
                    ['text' => 'Student Certificate'],
                    ['text' => 'Generate Certificate'],
                    ['text' => 'Student ID Card'],
                    ['text' => 'Generate ID Card'],
                    ['text' => 'Staff ID Card'],
                    ['text' => 'Generate Staff ID Card'],
                ],
            ],
            // Communicate
            [
                'text' => 'Communicate',
                'icon' => 'fas fa-bullhorn',
                'submenus' => [
                    ['text' => 'Notice Board'],
                    ['text' => 'Send Email'],
                    ['text' => 'Send SMS'],
                    ['text' => 'Email / SMS Log'],
                    ['text' => 'Schedule Email SMS Log'],
                    ['text' => 'Login Credentials Send'],
                    ['text' => 'Email Template'],
                    ['text' => 'SMS Template'],
                ],
            ],
            // Tuckshop
            [
                'text' => 'Tuckshop',
                'icon' => 'fas fa-store',
                'submenus' => [
                    ['text' => 'Inventory Management'],
                    ['text' => 'Sales'],
                    ['text' => 'Orders'],
                    ['text' => 'Suppliers'],
                    ['text' => 'Financial Reports'],
                ],
            ],
            // Maintenance
            [
                'text' => 'Maintenance',
                'icon' => 'fas fa-tools',
                'submenus' => [
                    ['text' => 'Request Maintenance'],
                    ['text' => 'Ongoing Repairs'],
                    ['text' => 'Maintenance Schedule'],
                    ['text' => 'Maintenance Reports'],
                    ['text' => 'Service Providers'],
                ],
            ],
            // Grandbox (Chat Application)
            [
                'text' => 'Grandbox',
                'icon' => 'fas fa-comments',
            ],
            // Grand-ebuy (E-commerce Application)
            [
                'text' => 'Grand-ebuy',
                'icon' => 'fas fa-shopping-cart',
            ],
            // Item Claim (Lost and Found)
            [
                'text' => 'Item Claim',
                'icon' => 'fas fa-search-location',
                'submenus' => [
                    ['text' => 'Report Lost Item'],
                    ['text' => 'View Found Items'],
                    ['text' => 'Lost & Found Reports'],
                ],
            ],
            // Download Center
            [
                'text' => 'Download Center',
                'icon' => 'fas fa-download',
                'submenus' => [
                    ['text' => 'Content Type'],
                    ['text' => 'Content Share List'],
                    ['text' => 'Upload Content'],
                    ['text' => 'Video Tutorial'],
                ],
            ],
            // Examinations
            [
                'text' => 'Examinations',
                'icon' => 'fas fa-edit',
                'submenus' => [
                    ['text' => 'Publish Results'],
                    ['text' => 'View Results'],
                    ['text' => 'View Results Queries'],
                    ['text' => 'Enter Results'],
                    ['text' => 'View Past Papers'],
                    ['text' => 'Upload to Question Bank'],
                    ['text' => 'Exam Timetables'],
                    ['text' => 'Pupils Performance Report'],
                    ['text' => 'Grading System'],
                    ['text' => 'Generate Report Card'],
                    ['text' => 'Exam Analysis'],
                ],
            ],
            // Expenses
            [
                'text' => 'Expenses',
                'icon' => 'fas fa-wallet',
                'submenus' => [
                    ['text' => 'Add Expense'],
                    ['text' => 'Expense List'],
                    ['text' => 'Expense Group'],
                    ['text' => 'Income Head'],
                    ['text' => 'Income List'],
                ],
            ],
            // Expenses
            [
                'text' => 'Expenses',
                'icon' => 'fas fa-wallet',
                'submenus' => [
                    ['text' => 'Add Expense'],
                    ['text' => 'Expense List'],
                    ['text' => 'Expense Group'],
                    ['text' => 'Income Head'],
                    ['text' => 'Income List'],
                ],
            ],
            // Fees Collection
            [
                'text' => 'Fees Collection',
                'icon' => 'fas fa-money-check-alt',
                'submenus' => [
                    ['text' => 'Fees Type'],
                    ['text' => 'Fees Group'],
                    ['text' => 'Fees Master'],
                    ['text' => 'Fees Discount'],
                    ['text' => 'Collect Fees'],
                    ['text' => 'Search Fees Payment'],
                    ['text' => 'Search Due Fees'],
                    ['text' => 'Create invoices'],
                ],
            ],
            // Income
            [
                'text' => 'Income',
                'icon' => 'fas fa-coins',
                'submenus' => [
                    ['text' => 'Add Income'],
                    ['text' => 'Income List'],
                    ['text' => 'Income Head'],
                ],
            ],
            // Inventory
            [
                'text' => 'Inventory',
                'icon' => 'fas fa-boxes',
                'submenus' => [
                    ['text' => 'Issue Item'],
                    ['text' => 'Issue Return'],
                    ['text' => 'Add Item Stock'],
                    ['text' => 'Item Store'],
                    ['text' => 'Item Supplier'],
                ],
            ],
            // Reports
            [
                'text' => 'Reports',
                'icon' => 'fas fa-file-alt',
                'submenus' => [
                    ['text' => 'Student Report'],
                    ['text' => 'Staff Report'],
                    ['text' => 'Fees Report'],
                    ['text' => 'Attendance Report'],
                    ['text' => 'Library Report'],
                    ['text' => 'Transport Report'],
                    ['text' => 'Hostel Report'],
                ],
            ],
            // Front CMS
            [
                'text' => 'Front CMS',
                'icon' => 'fas fa-globe',
                'submenus' => [
                    ['text' => 'Manage Front CMS'],
                    ['text' => 'Menu Manager'],
                    ['text' => 'Event'],
                    ['text' => 'Gallery'],
                    ['text' => 'Banner Images'],
                    ['text' => 'News'],
                    ['text' => 'Pages'],
                ],
            ],
            // Settings
            [
                'text' => 'Settings',
                'icon' => 'fas fa-cogs',
                'submenus' => [
                    ['text' => 'General Settings'],
                    ['text' => 'Session Settings'],
                    ['text' => 'Notification Settings'],
                    ['text' => 'SMS Settings'],
                    ['text' => 'Email Settings'],
                    ['text' => 'Payment Methods'],
                    ['text' => 'Print Header Footer'],
                    ['text' => 'Front CMS Settings'],
                    ['text' => 'Roles Permissions'],
                    ['text' => 'Backup Restore'],
                    ['text' => 'Languages'],
                    ['text' => 'Currency'],
                    ['text' => 'Users'],
                    ['text' => 'Modules'],
                    ['text' => 'Custom Fields'],
                    ['text' => 'Captcha Settings'],
                    ['text' => 'System Fields'],
                    ['text' => 'Student Profile Update'],
                    ['text' => 'Online Admission'],
                    ['text' => 'File Types'],
                    ['text' => 'Sidebar Menu'],
                    ['text' => 'System Update'],
                ],
            ],




        ];

        foreach ($menus as $menu) {
            $createdMenu = Menu::create([
                'text' => $menu['text'],
                'icon' => $menu['icon'],
                'is_active'=> true
            ]);

            if (isset($menu['submenus'])) {
                foreach ($menu['submenus'] as $submenu) {
                    Submenu::create([
                        'menu_id' => $createdMenu->id,
                        'text' => $submenu['text'],
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}
