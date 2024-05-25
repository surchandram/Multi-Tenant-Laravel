<?php

namespace SAAS\Domain\Users\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use SAAS\Domain\Users\Models\UserInvitation;

class UserInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Model instance of UserInvitation.
     *
     * @var \SAAS\Domain\Users\Models\UserInvitation
     */
    public $invitation;

    /**
     * The url for accepting the invitation.
     *
     * @var string
     */
    public $acceptUrl;

    /**
     * The url for accepting the invitation for existing users.
     *
     * @var string
     */
    public $acceptUrlExisting;

    /**
     * Invitation message.
     *
     * @var string
     */
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserInvitation $invitation)
    {
        $this->invitation = $invitation;
        $this->acceptUrl = route('auth.invitations.accept', [
            $invitation, 'identifier' => $invitation->identifier,
        ]);

        $this->acceptUrlExisting = route('auth.invitations.accept.existing', [
            $invitation, 'identifier' => $invitation->identifier,
        ]);

        $message = $invitation->message;

        if ($invitation->role_id) {
            $message = __(
                ':name has invited you to join as :type.', [
                    'name' => $invitation->referable->name,
                    'type' => $invitation->role->name,
                ]
            );
        } else {
            $message = __(
                'You have been invited to sign up to :app by :name', [
                    'app' => config('app.name'),
                    'name' => $invitation->referable->name,
                ]
            );
        }

        $this->message = $message;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $subject = 'User Invitation';

        if ($this->invitation->role_id) {
            $subject = 'Invitation to join as '.$this->invitation->role->name;
        } elseif ($this->invitation->referable) {
            $subject = 'Invitation from '.$this->invitation->referable->name;
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $template = 'emails.users.invitations.created';

        if ($exists = config('saas.invitations.mail_templates.'.$this->invitation->type)) {
            $template = $exists;
        }

        return new Content(
            markdown: $template,
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
