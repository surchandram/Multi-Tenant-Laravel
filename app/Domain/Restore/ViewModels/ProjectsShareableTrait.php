<?php

namespace SAAS\Domain\Restore\ViewModels;

use SAAS\Domain\Restore\Enums\ProjectStatuses;

trait ProjectsShareableTrait
{
    public function __destruct()
    {
        if (filled($this->project)) {
            $this->project->ensureThreadExists();

            $this->project->loadMissing([
                'thread.users',
                'thread.messages.user',
                'thread.messages.parent.user',
                'documents.type',
            ]);
        }
    }

    public function statuses()
    {
        return collect(ProjectStatuses::cases())->mapWithKeys(fn ($enum) => [
            $enum->value => [
                'label' => $enum->label(),
                'priority_level' => $enum->priorityLevel(),
            ],
        ]);
    }

    public function fieldLabels()
    {
        return [
            'name' => __('Name'),
            'type_id' => __('Type'),
            'description' => __('Description'),
            'overview' => __('Overview'),
            'contacted_at' => __('Date Contacted'),
            'loss_occurred_at' => __('Date Loss Occurred'),
            'point_of_loss' => __('Point of Loss'),
            'category_id' => __('Category'),
            'class_id' => __('Class'),
            'starts_at' => __('Starts From'),
            'ends_at' => __('Ends On'),
            'team_id' => __('Team assigned'),
            'address' => __('Address'),
            'address_1' => __('Address line 1'),
            'address_2' => __('Address line 2'),
            'state' => __('State'),
            'city' => __('City'),
            'postal_code' => __('Postal code'),
            'country_id' => __('Country'),
            'country' => __('Country'),
            'owner' => __('Owner'),
            'email' => __('Email'),
            'phone' => __('Phone'),
            'insurance' => __('Insurance'),
            'company' => __('Company'),
            'agent' => __('Agent'),
            'adjuster' => __('Adjuster'),
            'claim_no' => __('Claim no'),
            'policy_no' => __('Policy no'),
            'deductible' => __('Deductible'),
        ];
    }
}
