<?php

namespace SAAS\Domain\Restore\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Restore\Models\Project;

class ProjectStatusUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public readonly Project $project,
        public readonly Company $company,
        public readonly bool $forCustomer = false,
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('emails.projects.status', [
            'project' => $this->project,
            'company' => $this->company,
            'forCustomer' => $this->forCustomer,
            'url' => $this->forCustomer ? route('tenant.customers.portal.projects.show', [$this->company->domain, $this->project])
                : route('tenant.switch', [
                    $this->company,
                    'redirect_url' => route('restore.projects.show', $this->project),
                ]),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
