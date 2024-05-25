<?php

namespace SAAS\Domain\Users\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Users\DataTransferObjects\UserInvitationData;
use SAAS\Domain\Users\Models\UserInvitation;

class SendUserInvitationAction
{
    public static function execute(UserInvitationData $userInvitationData): UserInvitation
    {
        try {
            $model = DB::transaction(function () use ($userInvitationData) {
                $fillableData = [
                    'name' => $userInvitationData->name,
                    'email' => $userInvitationData->email,
                    'role_id' => $userInvitationData->role?->id,
                    'role_expires_at' => $userInvitationData->role_expires_at,
                    'type' => $userInvitationData->type,
                    'message' => $userInvitationData->message,
                    'data' => $userInvitationData->data,
                ];

                $invitation = new UserInvitation;
                $invitation->fill($fillableData);
                $invitation->referable()->associate($userInvitationData->referable);
                $invitation->save();

                return $invitation->refresh();
            });
        } catch (\Exception $e) {
            Log::error('Failed sending user invitation.', [$e]);

            throw $e;
        }

        return $model;
    }
}
