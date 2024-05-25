<?php

namespace SAAS\Domain\Restore\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Miracuthbert\Multitenancy\Models\Tenant;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Users\Models\UserInvitation;

class CustomerInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Project|ProjectData $project;

    public Tenant|CompanyData $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public readonly UserInvitation $userInvitation
    ) {
        $this->project = ProjectData::from($this->userInvitation->data['mail']['project']);
        $this->company = CompanyData::from($this->userInvitation->data['mail']['company']);

        $this->afterCommit();
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Work Authorization Confirmation',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.tenant.project.customer.invitation',
            with: [
                'url' => route('tenant.customers.portal.auth.invitation.project.callback', [
                    $this->company->domain,
                    $this->userInvitation->identifier,
                    $this->project->id,
                ]),
                'project' => $this->project,
                'company' => $this->company,
                'companyName' => $this->company->name,
                'customerName' => trim(Arr::first(Str::of($this->project->owner->name)->ucsplit())),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
