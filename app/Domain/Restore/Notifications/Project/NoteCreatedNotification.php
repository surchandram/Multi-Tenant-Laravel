<?php

namespace SAAS\Domain\Restore\Notifications\Project;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Threads\DataTransferObjects\MessageData;

class NoteCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public ?string $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public readonly mixed $project,
        public readonly mixed $message,
        public readonly Company $company,
    ) {
        $this->url = route('tenant.switch', [
            $this->company,
            'redirect_url' => route('restore.projects.show', $this->project['id']),
        ]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'broadcast'];
    }

    /**
     * Determine the notification's delivery delay.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function withDelay($notifiable)
    {
        return [
            'broadcast' => now()->addSeconds(5),
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Note Posted')
            ->markdown('emails.tenant.project.note.created', [
                'message' => MessageData::from($this->message),
                'project' => ProjectData::from($this->project),
                'url' => $this->url,
            ]);
    }

    /**
     * Get the type of the notification being broadcast.
     *
     * @return string
     */
    public function broadcastType()
    {
        return 'restore.project.note.created';
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => MessageData::from($this->message),
            'project' => ProjectData::from($this->project),
            'url' => $this->url,
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
            'message' => MessageData::from($this->message),
            'project' => ProjectData::from($this->project),
            'url' => $this->url,
        ];
    }
}
