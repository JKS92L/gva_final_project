<?php

use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'gva-sms',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Grandview - SMS</b>',
    'logo_img' => 'vendor/adminlte/dist/img/gva_logos/grand view-PNG.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Grandview Academy-SMS',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/gva_logos/grand view-PNG.png', //sms_project/public/vendor/adminlte/dist/img/gva_logos/grand view-PNG.png
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/gva_logos/grand view-PNG.png',
            'alt' => 'GVA Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-gray',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    // 'layout_topnav' => null,
    // 'layout_boxed' => null,
    // 'layout_fixed_sidebar' => null,
    // 'layout_fixed_navbar' => null,
    // 'layout_fixed_footer' => null,
    // 'layout_dark_mode' => null,
    'layout_topnav' => null, // Disables top navigation, if you want the sidebar to remain visible
    'layout_boxed' => null, // Keeps the layout full-width
    'layout_fixed_sidebar' => true, // Fixes the sidebar in place
    'layout_fixed_navbar' => true, // Fixes the top navigation bar in place
    'layout_fixed_footer' => false, // Does not fix the footer (adjust if needed)
    'layout_dark_mode' => null, // Keeps the theme as specified


    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-success',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light fixed-top', // Add 'fixed-top' class here
    'classes_topnav_nav' => 'navbar-expand', // Ensure this is appropriate for your needs
    'classes_topnav_container' => 'container',


    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [

        // Navbar items:
        [
            // 'type' => 'navbar-search',
            // 'text' => 'search',
            // 'topnav_right' => true,
        ],
        [
            // 'type' => 'fullscreen-widget',
            // 'topnav_right' => true,
        ],
        [
            // 'type' => 'navbar-notification',
            // 'id' => 'my-notification',                // An ID attribute (required).
            // 'icon' => 'fas fa-bell',                  // A font awesome icon (required).
            // 'icon_color' => 'warning',                // The initial icon color (optional).
            // 'label' => 0,                             // The initial label for the badge (optional).
            // 'label_color' => 'danger',                // The initial badge color (optional).
            // 'url' => 'notifications/show',            // The url to access all notifications/elements (required).
            // 'topnav_right' => true,                   // Or "topnav => true" to place on the left (required).
            // 'dropdown_mode' => true,                  // Enables the dropdown mode (optional).
            // 'dropdown_flabel' => 'All notifications', // The label for the dropdown footer link (optional).
            // 'update_cfg' => [
            //     'url' => 'notifications/get',         // The url to periodically fetch new data (optional).
            //     'period' => 30,                       // The update period for get new data (in seconds, optional).
            // ]

        ],
        [
            // Notifications (existing)
            'type' => 'navbar-notification',
            'id' => 'my-notification',
            'icon' => 'fas fa-bell',
            'url' => 'notifications/show',
            'topnav_right' => true,
            'dropdown_mode' => true,
            'dropdown_flabel' => 'All notifications',
            'update_cfg' => [
                'url' => 'notifications/get',
                'period' => 30,
            ],
        ],
        [
            // Messages
            'type' => 'navbar-notification',
            'id' => 'messages-notification',
            'icon' => 'fas fa-envelope',  // Message icon
            'url' => 'messages/show',
            'topnav_right' => true,
            'dropdown_mode' => true,
            'dropdown_flabel' => 'All messages',
            'update_cfg' => [
                'url' => 'messages/get',
                'period' => 60,  // Poll for new messages every 60 seconds
            ],
        ],
        [
            // Calendar for events/exams/meetings
            'type' => 'navbar-notification',
            'id' => 'calendar-notification',
            'icon' => 'fas fa-calendar-alt',  // Calendar icon
            'url' => 'calendar/show',
            'topnav_right' => true,
            'dropdown_mode' => false, // This can open the full calendar view
        ],
        // [
        //     // Profile Dropdown
        //     'type' => 'navbar-dropdown',
        //     'icon' => 'fas fa-user',  // Profile icon
        //     'topnav_right' => true,
        //     'dropdown_items' => [
        //         [
        //             'text' => 'Profile',
        //             'url' => 'user/profile',
        //         ],
        //         [
        //             'text' => 'Settings',
        //             'url' => 'user/settings',
        //         ],
        //         [
        //             'text' => 'Logout',
        //             'url' => 'logout',
        //         ],
        //     ],
        // ],





        // SIDEBAR
        // Dashboard
        // [
        //     'text' => 'Dashboard',
        //     'icon' => 'fas fa-users-cog',
        //     // 'can' => 'manage-users',
        //     'url' => 'admin/dashboard',
        //     'icon' => 'fas fa-tachometer-alt'
        //     // 'active' =>true
        // ],

        // User management
        [
            'text' => 'User Management',
            'icon' => 'fas fa-users-cog',
            'submenu' => [
                [
                    'text' => 'User List',
                    'url' => 'admin/user-list',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'User Responsibilities',
                    'url' => 'admin/user-responsibility',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'User Permissions',
                    'url' => 'admin/user-permissions',
                    'icon' => 'fa fa-angle-double-right',
                ],

            ],
        ],
     //Teacher Management
        [
            'text' => 'Teacher Management',
            'icon' => 'fas fa-chalkboard-teacher',
            // 'can' => 'manage-teachers',
            'submenu' => [
                [
                    'text' => 'Assign Subject',
                    'url' => 'admin/teachers/assign-subject',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Lesson Observation',
                    'url' => 'admin/teachers/lesson-observation',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'File Monitoring',
                    'url' => 'admin/teachers/file-monitoring',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Teacher Appraisal', // Teacher Appraisal form
                    'url' => 'admin/teachers/communication-logs',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Assign responsibility', //observation reports, academic reports, attendance reports
                    'url' => 'admin/teachers/assign-responsibility',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'CPD Report', // Attendance report(Date, the role, Teacher's comments) teacher training sessions
                    'url' => 'admin/teachers/cpd-reports',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Teacher Timetable', // view and manage teacher timetables
                    'url' => 'admin/teachers/teacher-timetable',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Teacher Reports', //observation reports, academic reports, attendance reports
                    'url' => 'admin/teachers/teacher-reports',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Communication Logs', // logs of communication with parents or administration
                    'url' => 'admin/teachers/communication-logs',
                    'icon' => 'fa fa-angle-double-right',
                ],

            ],
        ],
       //Student info
        [
            'text' => 'Student Information',
            'icon' => 'fas fa-user-graduate',
            // 'can' => 'manage-students',
            'submenu' => [
                [
                    'text' => 'Student Details',
                    'url' => 'admin/student-details',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Student Admission',
                    'url' => 'admin/student-admission',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Online Admission',
                    'url' => 'admin/online-admission',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Disable Students',
                    'url' => 'admin/disable-students',
                    'icon' => 'fa fa-angle-double-right',
                ],

                [
                    'text' => 'Bulk Delete',
                    'url' => 'admin/bulk-delete',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Student Categories',
                    'url' => 'admin/student-categories',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Student Register',
                    'url' => 'admin/student-register',
                    'icon' => 'fa fa-angle-double-right',
                ],

                [
                    'text' => 'Disable Reason',
                    'url' => 'admin/disable-reason',
                    'icon' => 'fa fa-angle-double-right',
                ],

            ],
        ],
        // // CPD Meetings
        [
            'text' => 'CPD Meetings',
            'icon' => 'fas fa-calendar-check',
            // 'can' => 'manage-cpd',
            'submenu' => [
                [
                    'text' => 'Schedule CPD Meetings',
                    'url' => 'admin/schedule-cpd-meetings',
                    'icon' => 'fa fa-angle-double-right',
                    'description' => 'Create and schedule new CPD meetings for teachers.',
                    // Allows the CPD Coordinator to set up new CPD meeting events, including date, time, and location.
                ],
                [
                    'text' => 'View Upcoming Meetings',
                    'url' => 'admin/view-upcoming-cpd-meetings',
                    'icon' => 'fa fa-angle-double-right',
                    'description' => 'View and manage all upcoming CPD meetings.',
                    // Provides an overview of all scheduled CPD meetings, allowing for management and adjustments.
                ],
                [
                    'text' => 'Manage CPD Calender',
                    'url' => 'admin/manage-cpd-calendar',
                    'icon' => 'fa fa-angle-double-right',
                    'description' => 'View and manage all upcoming CPD meetings.',
                    // Provides an overview of all scheduled CPD meetings, allowing for management and adjustments.
                ],
                [
                    'text' => 'view CPD Calendar',
                    'url' => 'admin/cpd-calendar',
                    'icon' => 'fa fa-angle-double-right',
                    'description' => 'View and manage the CPD meeting calendar.',
                    // Displays a calendar view of all scheduled CPD meetings for better organization and scheduling.
                ],
                [
                    'text' => 'CPD Meeting Reports',
                    'url' => 'admin/cpd-meeting-reports',
                    'icon' => 'fa fa-angle-double-right',
                    'description' => 'Generate and view reports related to CPD meetings.',
                    // Provides tools to generate various reports on CPD meetings, such as participation rates and session outcomes.
                ],
                [
                    'text' => 'CPD Resources',
                    'url' => 'admin/cpd-resources',
                    'icon' => 'fa fa-angle-double-right',
                    'description' => 'Manage and distribute CPD resources and materials.',
                    // Allows for the management and distribution of resources like presentation materials, handouts, and reading materials.
                ],
                [
                    'text' => 'Feedback and Evaluation',
                    'url' => 'admin/feedback-evaluation',
                    'icon' => 'fa fa-angle-double-right',
                    'description' => 'Collect feedback and evaluate CPD sessions.',
                    // Collects participant feedback on CPD sessions and evaluates their effectiveness.
                ],
                [
                    'text' => 'CPD Attendance Reports',
                    'url' => 'admin/cpd-attendance-reports',
                    'icon' => 'fa fa-angle-double-right',
                    'description' => 'Access detailed reports on CPD meeting attendance.',
                    // Provides detailed reports and analytics on attendance trends and statistics for CPD meetings.
                ],
                [
                    'text' => 'Set CPD Goals',
                    'url' => 'admin/set-cpd-goals',
                    'icon' => 'fa fa-angle-double-right',
                    'description' => 'Define and track CPD goals for teachers.',
                    // Allows setting and tracking of professional development goals for teachers, aligning with their growth plans.
                ],
                [
                    'text' => 'CPD Budget',
                    'url' => 'admin/cpd-budget',
                    'icon' => 'fa fa-angle-double-right',
                    'description' => 'Manage and monitor the budget for CPD activities.',
                    // Manages the financial aspects related to CPD, including tracking expenditures and planning budgets.
                ],
            ],
        ],


        // //Academics
        [
            'text' => 'Academics',
            'icon' => 'fas fa-book',
            'submenu' => [
                [
                    'text' => 'Class Timetable',
                    'url' => 'admin/class-timetable',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Period Register',
                    'url' => 'admin/period-register',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Teachers Timetable',
                    'url' => 'admin/teachers-timetable',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Assign Class Teacher',
                    'url' => 'admin/assign-class-teacher',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Promote Students',
                    'url' => 'admin/promote-students',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Subjects List',
                    'url' => 'admin/subjects',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Create subjects',
                    'url' => 'admin/create-subjects',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Class Lists',
                    'url' => 'admin/class',
                    'icon' => 'fa fa-angle-double-right',
                ]
            ],
        ],
      //Homework
        [
            'text' => 'Homework',
            'icon' => 'fas fa-book-open',
            'submenu' => [
                [
                    'text' => 'Add Homework',
                    'url' => 'admin/add-homework',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Homework Evaluation',
                    'url' => 'admin/homework-evaluation',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Evaluation Report',
                    'url' => 'admin/evaluation-report',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Sickbay Menu
        [
            'text' => 'Sickbay',
            'icon' => 'fas fa-medkit',  // Medkit icon for medical-related functions
            'submenu' => [
                [
                    'text' => 'Prescribe Medication',
                    'url' => 'admin/sickbay/prescribe',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Issue Medication',
                    'url' => 'admin/sickbay/issue-medication',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Medical Reports',
                    'url' => 'admin/sickbay/reports',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Recommend Actions',
                    'url' => 'admin/sickbay/recommendations',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Patient History',
                    'url' => 'admin/sickbay/patient-history',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        //Library
        [
            'text' => 'Library',
            'icon' => 'fas fa-book-reader',
            // 'can' => 'manage-library',
            'submenu' => [
                [
                    'text' => 'Books',
                    'url' => 'admin/books',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Issue Return',
                    'url' => 'admin/library-issue-return',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Issue Books',
                    'url' => 'admin/issue-books',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Add Books',
                    'url' => 'admin/add-books',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Departments Menu
        [
            'text' => 'Departments',
            'icon' => 'fas fa-building',  // Building icon for departmental management
            'submenu' => [
                [
                    'text' => 'Departmental Plans',
                    'url' => 'admin/departments/plan',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Assign roles',
                    'url' => 'admin/departments/assign-roles',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Departmental List',
                    'url' => 'admin/departments/list',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Departmental Inventory',
                    'url' => 'admin/departments/inventory',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
       // Committee Menu
        [
            'text' => 'Committee',
            'icon' => 'fas fa-users-cog',  // Users Cog icon for management-related functions
            'submenu' => [
                [
                    'text' => 'Prepare Budget',
                    'url' => 'admin/committee/prepare-budget',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Send Budget',
                    'url' => 'admin/committee/send-budget',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Committee Structure',
                    'url' => 'admin/committee/structure',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Meeting Minutes',
                    'url' => 'admin/committee/meeting-minutes',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Task Assignment',
                    'url' => 'admin/committee/assign-tasks',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Sports Menu
        [
            'text' => 'Sports',
            'icon' => 'fas fa-futbol',  // Soccer Ball icon for sports activities
            'submenu' => [
                [
                    'text' => 'Teams',
                    'url' => 'admin/sports/teams',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Events',
                    'url' => 'admin/sports/events',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Tournaments',
                    'url' => 'admin/sports/tournaments',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Coaches',
                    'url' => 'admin/sports/coaches',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Athlete Management',
                    'url' => 'admin/sports/athletes',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
     // Clubs Menu
        [
            'text' => 'Clubs',
            'icon' => 'fas fa-users',  // Users icon for group activities like clubs
            'submenu' => [
                [
                    'text' => 'Club List',
                    'url' => 'admin/clubs/list',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Club Events',
                    'url' => 'admin/clubs/events',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Membership Management',
                    'url' => 'admin/clubs/membership',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Club Leaders',
                    'url' => 'admin/clubs/leaders',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Budget and Finance',
                    'url' => 'admin/clubs/finance',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Human Resource
        [
            'text' => 'Human Resource',
            'icon' => 'fas fa-users',
            // 'can' => 'manage-human-resource',
            'submenu' => [

                [
                    'text' => 'Staff Directory',
                    'url' => 'admin/staff-directory',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Staff Attendance',
                    'url' => 'admin/staff-attendance',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'view Leave Request',
                    'url' => 'admin/leave-request',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'send Leave Request',
                    'url' => 'admin/send-leave-request',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Payroll',
                    'url' => 'admin/payroll',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'View payslip',
                    'url' => 'admin/view-playslip',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'send bulk payslips',
                    'url' => 'admin/send-bulk-playslip',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Payroll Reports',
                    'url' => 'admin/payroll-reports',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Pay Slip',
                    'url' => 'admin/pay-slip',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'HR Reports',
                    'url' => 'admin/hr-reports',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Management roles',
                    'url' => 'admin/management-roles',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        //Hostel
        [
            'text' => 'Hostel',
            'icon' => 'fas fa-bed',
            // 'can' => 'manage-hostel',
            'submenu' => [
                [
                    'text' => 'Hostel Rooms',
                    'url' => 'admin/hostel-rooms',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Hostel Members',
                    'url' => 'admin/hostel-members',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Hostel Reports',
                    'url' => 'admin/hostel-reports',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Hostel List',
                    'url' => 'admin/hostel-list',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Attendance
        [
            'text' => 'Attendance Register',
            'icon' => 'fas fa-calendar-check',
            'submenu' => [
                [
                    'text' => 'View Student Attendance',
                    'url' => 'admin/view-student-attendance',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Approve Permission',
                    'url' => 'admin/approve-permission',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Request Permission',
                    'url' => 'admin/approve-permission',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Attendance By Report',
                    'url' => 'admin/attendance-by-date',
                    'icon' => 'fa fa-angle-double-right',
                ]
            ],
        ],
        //Alumni
        [
            'text' => 'Alumni',
            'icon' => 'fas fa-user-graduate',
            // 'can' => 'manage-alumni',
            'submenu' => [
                [
                    'text' => 'Manage Alumni',
                    'url' => 'admin/manage-alumni',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'view Events',
                    'url' => 'admin/alumni-events',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'create Events',
                    'url' => 'admin/create-events',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Alumni List',
                    'url' => 'admin/alumni-list',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Add Alumni',
                    'url' => 'admin/add-alumni',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Alumni Reports',
                    'url' => 'admin/alumni-reports',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],



        //Behaviour Records
        [
            'text' => 'Behaviour Records',
            'icon' => 'fas fa-gavel',
            // 'can' => 'manage-behaviour-records',
            'submenu' => [
                [
                    'text' => 'Assign Incident',
                    'url' => 'admin/assign-incident',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'send appeal',
                    'url' => 'admin/send-appeal',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'view appeal responses',
                    'url' => 'admin/view-appeal-response',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'view appeals',
                    'url' => 'admin/view-appeals',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Incidents',
                    'url' => 'admin/incidents',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Reports',
                    'url' => 'admin/behaviour-reports',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Setting',
                    'url' => 'admin/behaviour-setting',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        //Certificate
        [
            'text' => 'Certificate',
            'icon' => 'fas fa-certificate',
            // 'can' => 'manage-certificates',
            'submenu' => [
                [
                    'text' => 'Student Certificate',
                    'url' => 'admin/student-certificate',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Generate Certificate',
                    'url' => 'admin/generate-certificate',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Student ID Card',
                    'url' => 'admin/student-id-card',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Generate ID Card',
                    'url' => 'admin/generate-id-card',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Staff ID Card',
                    'url' => 'admin/staff-id-card',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Generate Staff ID Card',
                    'url' => 'admin/generate-staff-id-card',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        //Communicate
        [
            'text' => 'Communicate',
            'icon' => 'fas fa-bullhorn',
            // 'can' => 'manage-communications',
            'submenu' => [
                [
                    'text' => 'Notice Board',
                    'url' => 'admin/notice-board',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Send Email',
                    'url' => 'admin/send-email',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Send SMS',
                    'url' => 'admin/send-sms',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Email / SMS Log',
                    'url' => 'admin/email-sms-log',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Schedule Email SMS Log',
                    'url' => 'admin/schedule-email-sms-log',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Login Credentials Send',
                    'url' => 'admin/login-credentials-send',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Email Template',
                    'url' => 'admin/email-template',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'SMS Template',
                    'url' => 'admin/sms-template',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Tuckshop Menu
        [
            'text' => 'Tuckshop',
            'icon' => 'fas fa-store',  // Store icon for retail/shop-related functions
            'submenu' => [
                [
                    'text' => 'Inventory Management',
                    'url' => 'admin/tuckshop/inventory',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Sales',
                    'url' => 'admin/tuckshop/sales',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Orders',
                    'url' => 'admin/tuckshop/orders',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Suppliers',
                    'url' => 'admin/tuckshop/suppliers',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Financial Reports',
                    'url' => 'admin/tuckshop/reports',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],

        // Maintenance Menu
        [
            'text' => 'Maintenance',
            'icon' => 'fas fa-tools',  // Tools icon for maintenance-related functions
            'submenu' => [
                [
                    'text' => 'Request Maintenance',
                    'url' => 'admin/maintenance/request',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Ongoing Repairs',
                    'url' => 'admin/maintenance/ongoing-repairs',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Maintenance Schedule',
                    'url' => 'admin/maintenance/schedule',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Maintenance Reports',
                    'url' => 'admin/maintenance/reports',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Service Providers',
                    'url' => 'admin/maintenance/service-providers',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],

       // Grandbox (Chat Application) Menu
        [
            'text' => 'Grandbox',
            'icon' => 'fas fa-comments',  // Comments icon for chat/messaging
            'url'  => 'admin/grandbox',
        ],

   // Grand-ebuy (E-commerce Application) Menu
        [
            'text' => 'Grand-ebuy',
            'icon' => 'fas fa-shopping-cart',  // Shopping cart icon for e-commerce
            'url'  => 'admin/grand-ebuy',
        ],

        // Item Claim (Lost and Found) Menu
        [
            'text' => 'Item Claim',
            'icon' => 'fas fa-search-location',  // Search location icon for lost and found
            'submenu' => [
                [
                    'text' => 'Report Lost Item',
                    'url' => 'admin/item-claim/report-lost',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'View Found Items',
                    'url' => 'admin/item-claim/found-items',
                    'icon' => 'fa fa-angle-double-right',
                ],
                // [
                //     'text' => 'Claim Item',
                //     'url' => 'admin/item-claim/claim-item',
                //     'icon' => 'fa fa-angle-double-right',
                // ],
                [
                    'text' => 'Lost & Found Reports',
                    'url' => 'admin/item-claim/reports',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Download Center
        [
            'text' => 'Download Center',
            'icon' => 'fas fa-download',
            // 'can' => 'manage-download-center',
            'submenu' => [
                [
                    'text' => 'Content Type',
                    'url' => 'admin/content-type',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Content Share List',
                    'url' => 'admin/content-share-list',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Upload / Share Content',
                    'url' => 'admin/upload-share-content',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Video Tutorial',
                    'url' => 'admin/video-tutorial',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Examinations
        [
            'text' => 'Examinations',
            'icon' => 'fas fa-edit',
            'submenu' => [
                [
                    'text' => 'Publish Results',
                    'url' => 'admin/publish-results',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'View Results',
                    'url' => 'admin/view-results',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'View Results Queries',
                    'url' => 'admin/view-results-queries',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Enter  Results',
                    'url' => 'admin/enter-results',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'View Past Papers',
                    'url' => 'admin/view-past-papers',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Upload to Question Bank',
                    'url' => 'admin/upload-exams',
                    'icon' => 'fa fa-angle-double-right',
                ],
                
                [
                    'text' => 'Exam Timetables',
                    'url' => 'admin/exam-timetable',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Pupils Performance Report',
                    'url' => 'admin/pupils-performance-report',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Grading System',
                    'url' => 'admin/grading-grade',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Generate Report Card',
                    'url' => 'admin/generate-report-card',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Exam Analysis',
                    'url' => 'admin/ecz-exam-analysis',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Expenses
        [
            'text' => 'Expenses',
            'icon' => 'fas fa-wallet',
            // 'can' => 'manage-expenses',
            'submenu' => [
                [
                    'text' => 'Add Expense',
                    'url' => 'admin/add-expense',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Expense List',
                    'url' => 'admin/expense-list',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Expense Group',
                    'url' => 'admin/expense-group',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Income Head',
                    'url' => 'admin/income-head',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Income List',
                    'url' => 'admin/income-list',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Fees Collection
        [
            'text' => 'Fees Collection',
            'icon' => 'fas fa-money-check-alt',
            'submenu' => [
                [
                    'text' => 'Fees Type',
                    'url' => 'admin/fees-type',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Fees Group',
                    'url' => 'admin/fees-group',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Fees Master',
                    'url' => 'admin/fees-master',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Fees Discount',
                    'url' => 'admin/fees-discount',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Collect Fees',
                    'url' => 'admin/collect-fees',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Search Fees Payment',
                    'url' => 'admin/search-fees-payment',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Search Due Fees',
                    'url' => 'admin/search-due-fees',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Create invoices',
                    'url' => 'admin/create-invoices',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Income
        [
            'text' => 'Income',
            'icon' => 'fas fa-coins',
            // 'can' => 'manage-income',
            'submenu' => [
                [
                    'text' => 'Add Income',
                    'url' => 'admin/add-income',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Income List',
                    'url' => 'admin/income-list',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Income Head',
                    'url' => 'admin/income-head',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Inventory
        [
            'text' => 'Inventory',
            'icon' => 'fas fa-boxes',
            // 'can' => 'manage-inventory',
            'submenu' => [
                [
                    'text' => 'Issue Item',
                    'url' => 'admin/issue-item',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Issue Return',
                    'url' => 'admin/issue-return',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Add Item Stock',
                    'url' => 'admin/add-item-stock',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Item Store',
                    'url' => 'admin/item-store',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Item Supplier',
                    'url' => 'admin/item-supplier',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Reports
        [
            'text' => 'Reports',
            'icon' => 'fas fa-file-alt',
            // 'can' => 'manage-reports',
            'submenu' => [
                [
                    'text' => 'Student Report',
                    'url' => 'admin/student-report',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Staff Report',
                    'url' => 'admin/staff-report',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Fees Report',
                    'url' => 'admin/fees-report',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Attendance Report',
                    'url' => 'admin/attendance-report',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Library Report',
                    'url' => 'admin/library-report',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Transport Report',
                    'url' => 'admin/transport-report',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Hostel Report',
                    'url' => 'admin/hostel-report',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Front CMS
        [
            'text' => 'Front CMS',
            'icon' => 'fas fa-globe',
            // 'can' => 'manage-front-cms',
            'submenu' => [
                [
                    'text' => 'Manage Front CMS',
                    'url' => 'admin/manage-front-cms',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Menu Manager',
                    'url' => 'admin/menu-manager',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Event',
                    'url' => 'admin/front-cms-event',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Gallery',
                    'url' => 'admin/front-cms-gallery',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Banner Images',
                    'url' => 'admin/banner-images',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'News',
                    'url' => 'admin/front-cms-news',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Pages',
                    'url' => 'admin/front-cms-pages',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],
        // Settings
        [
            'text' => 'Settings',
            'icon' => 'fas fa-cogs',
            // 'can' => 'manage-settings',
            'submenu' => [
                [
                    'text' => 'General Settings',
                    'url' => 'admin/general-settings',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Session Settings',
                    'url' => 'admin/session-settings',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Notification Settings',
                    'url' => 'admin/notification-settings',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'SMS Settings',
                    'url' => 'admin/sms-settings',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Email Settings',
                    'url' => 'admin/email-settings',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Payment Methods',
                    'url' => 'admin/payment-methods',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Print Header Footer',
                    'url' => 'admin/print-header-footer',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Front CMS Settings',
                    'url' => 'admin/front-cms-settings',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Roles Permissions',
                    'url' => 'admin/roles-permissions',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Backup Restore',
                    'url' => 'admin/backup-restore',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Languages',
                    'url' => 'admin/languages',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Currency',
                    'url' => 'admin/currency',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Users',
                    'url' => 'admin/users',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Modules',
                    'url' => 'admin/modules',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Custom Fields',
                    'url' => 'admin/custom-fields',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Captcha Settings',
                    'url' => 'admin/captcha-settings',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'System Fields',
                    'url' => 'admin/system-fields',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Student Profile Update',
                    'url' => 'admin/student-profile-update',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Online Admission',
                    'url' => 'admin/online-admission',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'File Types',
                    'url' => 'admin/file-types',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'Sidebar Menu',
                    'url' => 'admin/sidebar-menu',
                    'icon' => 'fa fa-angle-double-right',
                ],
                [
                    'text' => 'System Update',
                    'url' => 'admin/system-update',
                    'icon' => 'fa fa-angle-double-right',
                ],
            ],
        ],


        // // //Website Management
        // // [
        //     'text' => 'Website Management',
        //     'icon' => 'fas fa-globe',
        //     // 'can' => 'manage-website',
        //     'submenu' => [
        //         [
        //             'text' => 'CMS Pages',
        //             'url' => 'admin/cms-pages',
        //             'icon' => 'fa fa-angle-double-right',
        //         ],
        //         [
        //             'text' => 'Banner Images',
        //             'url' => 'admin/banner-images',
        //             'icon' => 'fa fa-angle-double-right',
        //         ],
        //         [
        //             'text' => 'News & Events',
        //             'url' => 'admin/news-events',
        //             'icon' => 'fa fa-angle-double-right',
        //         ],
        //         [
        //             'text' => 'Gallery',
        //             'url' => 'admin/gallery',
        //             'icon' => 'fa fa-angle-double-right',
        //         ],
        //         [
        //             'text' => 'Testimonials',
        //             'url' => 'admin/testimonials',
        //             'icon' => 'fa fa-angle-double-right',
        //         ],
        //         [
        //             'text' => 'Contact Inquiries',
        //             'url' => 'admin/contact-inquiries',
        //             'icon' => 'fa fa-angle-double-right',
        //         ],
        //     ],
        // ],
        // //Logout
        // [
        //     'text' => 'Logout',
        //     'url' => 'admin/logout',
        //     'icon' => 'fas fa-sign-out-alt',
        // ],















    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
