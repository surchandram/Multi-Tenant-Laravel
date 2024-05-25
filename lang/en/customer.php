<?php

return [
    'greeting' => 'Welcome :name',

    'labels' => [
        'customer_portal' => 'Customer Portal',
        'customer_question' => 'Are you a customer?',

        'track_projects' => 'Track your projects',
        'track_job_progress' => 'Track job progress',
        'schedule_job' => 'Schedule job.',
        'sign_documents' => 'Sign documents.',
        'get_work_report' => 'Get work report.',

        'project' => 'Project',
        'team' => 'Team',
        'property' => 'Property',
        'start' => 'Start',
        'deadline' => 'Deadline',
        'status' => 'Status',
        'actions' => 'Actions',
        'summary' => 'Summary',
        'type' => 'Type',

        'date_contacted' => 'Date Contacted',
        'date_loss_occurred' => 'Loss Occurred',

        'documents' => 'Documents',
        'document_signed' => 'Signed',
        'document_not_signed' => 'Requires Signature',
        'document_view_signature' => 'View Signature',

        'daily_logs' => 'Work Updates',
    ],

    'buttons' => [
        'sign_document' => 'Sign',
        'change_document_sign' => 'Change Signature',
    ],

    'auth' => [
        'signup' => [
            'successful' => 'Account setup successful. You can now access the customer portal.',
        ],

        'invitation' => [
            'title' => 'Complete and Confirm Details',
            'subtitle' => 'Customer Portal Access',
            'confirmation_info' => 'Confirm and fill details below to access customer portal',
            'access_account_button' => 'Login',
            'setup_account_button' => 'Setup Account',
            'cancel_button' => 'Cancel',
        ],
    ],

    'dashboard' => [
        'greeting' => 'Welcome :name, everything looks great!',
    ],

    'project' => [
        'greeting' => 'Welcome :name, you can track and manage changes of the work done on your property here.',

        // buttons
        'accept_invitation_button' => 'View Job',

        'reschedule_button' => 'Reschedule',
        'authorize_button' => 'Authorize Start',
        'completion_approval_button' => 'Approve Completion',

        // messages
        'authorization_failed' => 'Failed authorizing project.',
        'authorization_succeeded' => 'Project authorization successful.',
    ],
];
