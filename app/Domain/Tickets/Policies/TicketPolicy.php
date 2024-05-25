<?php

namespace SAAS\Domain\Tickets\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use SAAS\Domain\Users\Models\User;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether a user is a ticket agent.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \Saasplayground\SupportTickets\Tickets\Models\Ticket
     * @return bool
     */
    public function isTicketAgent($user, $ticket)
    {
        return $user->id == $ticket->agent_id;
    }

    /**
     * Determine whether a user can update and resolve tickets.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @return bool
     */
    public function canUpdateAndResolveTickets($user)
    {
        return $user->can('update and resolve tickets');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('browse tickets');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \Saasplayground\SupportTickets\Tickets\Models\Ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Ticket $ticket)
    {
        return $user->can('browse tickets') ||
            $user->id == $ticket->user_id ||
            $this->isTicketAgent($user, $ticket);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \Saasplayground\SupportTickets\Tickets\Models\Ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Ticket $ticket)
    {
        return $user->id == $ticket->user_id || $this->isTicketAgent($user, $ticket) ||
                $this->canUpdateAndResolveTickets($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \Saasplayground\SupportTickets\Tickets\Models\Ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Ticket $ticket)
    {
        return $user->id == $ticket->user_id || $this->isTicketAgent($user, $ticket) ||
                $this->canUpdateAndResolveTickets($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \Saasplayground\SupportTickets\Tickets\Models\Ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Ticket $ticket)
    {
        return $this->isTicketAgent($user, $ticket) ||
                $this->canUpdateAndResolveTickets($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \Saasplayground\SupportTickets\Tickets\Models\Ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Ticket $ticket)
    {
        return $user->id == $ticket->user_id || $this->isTicketAgent($user, $ticket) ||
                $this->canUpdateAndResolveTickets($user);
    }
}
