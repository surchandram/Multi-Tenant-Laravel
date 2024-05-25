<?php

return [
    'greeting' => 'Welcome :name',

    'labels' => [
        'project' => 'Project',
        'projects' => 'Projects',
        'search_projects' => 'Search projects',
        'start_new_project' => 'Start new Project',

        'team' => 'Team',
        'assigned_to' => 'Assigned to',

        'property' => 'Property',
        'project_for' => 'Project for',
        'owner' => 'Owner',

        'start' => 'Start',
        'deadline' => 'Deadline',

        'status' => 'Status',
        'actions' => 'Actions',
        'summary' => 'Summary',

        'type' => 'Type',
        'category' => 'Category',
        'class' => 'Class',

        'project_schedule' => 'Project Schedule',
        'project_timeline' => 'Project Timeline',
        'point_of_loss' => 'Point of Loss',
        'date_contacted' => 'Date Contacted',
        'date_loss_occurred' => 'Date Loss Occurred',

        'project_assessment' => 'Project Assessment',
        'affected_areas' => 'Affected Areas',

        'insurance' => 'Insurance',
        'insurance_agent' => 'Insurance Agent',
        'insurance_adjuster' => 'Insurance Adjuster',
        'insurance_deductible' => 'Deductible',
        'claim_no' => 'Claim no',
        'policy_no' => 'Policy no',

        'editing' => 'Editing',
        'edited' => 'Edited',

        'edit_project' => 'Edit project',

        'link_device' => 'Link Device',

        'project_options' => 'Project options',
        'project_information' => 'Project Information',
        'moisture_map' => 'Moisture Map',
        'psychrometric_report' => 'Psychrometric Report',
        'work_report' => 'Work Report',

        'project_report_setup' => 'Project Report Setup',
        'export_report' => 'Export Report',

        'add_readings' => 'Add Readings',
        'adjust_readings' => 'Adjust Readings',

        'enter_readings_prompt' => 'Enter Readings for',
        'fill_days_readings_prompt' => 'Fill the fields below with days\' readings.',
        'affected_area' => 'Affected Area',
        'structure' => 'Structure',
        'material' => 'Material',

        'documents' => 'Documents',

        'daily_logs' => 'Daily Logs',
        'create_log' => 'New Daily Log',
        'add_log' => 'Add Log',

        'messages' => 'Notes',
        'notes' => 'Notes',
        'post_message' => 'Post',

        'new' => 'New',
        'new_message' => 'New',
        'replying_to' => 'Replying to',
        'new_note' => 'New Note',
        'start_conversation' => 'Start new',

        'authorization' => 'Authorization',
        'authorize' => 'Authorize',

        'project_authorization_agreement_prompt' => 'Sign agreements below to authorize project.',
    ],

    'dashboard' => [
        'greeting' => 'Welcome :name, everything looks great!',
    ],

    'project' => [
        // buttons
        'reschedule_button' => 'Reschedule',
        'customer_invite_button' => 'Send for Approval',
        'authorize_button' => 'Authorize Start',
        'completion_approval_button' => 'Approve Completion',
        'view_assessment_button' => 'View assessment',
        'view_invoice' => 'View invoice',
        'view_link_button' => 'View project',

        // messages
        'customer_invitation_sent' => 'Link to customer portal has been sent.',
        'customer_invitation_failed' => 'Failed sending link to customer.',

        'authorization_failed' => 'Failed authorizing project.',
        'authorization_succeeded' => 'Project authorization successful.',

        'report_setup_prompt' => 'Choose from the list below what you need for the report.',

        'no_documents_found' => 'No documents associated with this project.',

        'status_updated' => 'Project status successfully updated.',
        'status_update_failed' => 'Failed updating project status.',
        'status_transition_failed' => 'Project status change not allowed.',

        'status_change_prompt' => 'Are you sure you want to change project\'s status to: ":status"?',

        'status_mail' => [
            'changed' => 'Project Status Changed',

            // 'Project was **Approved**'
            'approved' => 'Project at :address, was **Approved**',
            // 'Project is **Ongoing**'
            'ongoing' => 'Project at :address, is now  **Ongoing**',
            // 'Project has been **Approved for Completion**'
            'approve_completion' => 'Project has been **Approved for Completion**',
            // 'Project owner/insurance company has been: **Invoiced**'
            'invoiced' => 'Project owner/insurance company has been: **Invoiced**',
            'invoiced_customer' => 'New invoice added for project at :address.',
            // 'Project invoiced has been: **Paid**'
            'paid' => 'Payment for project at :address, was successful.',
            // 'Project payment failed: **Payment Failed**'
            'payment_failed' => 'Payment for project at :address failed',
            // 'Project has been **Completed**'
            'completed' => 'Project at :address, has been **Completed**',
            // 'Project was **Cancelled**'
            'cancelled' => 'Project was **Cancelled**',
        ],

        // moisture map
        'moisture_map' => [
            // labels
            'readings_summary' => 'Summary of moisture map readings.',

            'add_new_structure' => 'Add new structure',
            'structure_monitor_prompt' => 'to monitor :affectedArea',

            'add_structure_for_area' => 'Fill form to add structure to be monitored in: :affectedArea',

            // messages
            'no_data_found' => 'No data found to build moisture map.',
            'setup_affected_areas' => 'You need to set affected areas under the project first.',
            'setup_structures' => 'Define structures to be monitored first.',
            'no_map_found' => 'No map setup found for :affectedArea',
            'material_readings_empty' => 'No readings found for this structure\'s material.',
        ],

        // logs
        'log_created' => 'Log created successfully.',
        'log_updated' => 'Log updated successfully.',
        'log_deleted' => 'Log deleted successfully.',
        'no_logs_found' => 'No logs found.',
        'log_posted_on' => 'Posted on :date by :name',
        'log_delete_confirm' => 'Are you sure you want to delete this log?',

        // threads / notes
        'message_created' => 'Note created successfully.',
        'message_reply_created' => 'Reply posted successfully.',
        'message_updated' => 'Note updated successfully.',
        'message_deleted' => 'Note deleted successfully.',
        'message_delete_failed' => 'Failed deleting note.',
        'no_message_found' => 'No notes found.',
        'message_posted_on' => 'Posted on :date by :name',
        'message_delete_confirm' => 'Are you sure you want to delete this note?',
    ],
];
