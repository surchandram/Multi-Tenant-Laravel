<?php

namespace SAAS\Domain\Users\Observers;

use SAAS\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRelationshipObserver
{
    /**
     * Instance of User.
     *
     * @var \SAAS\Domain\Users\Models\User
     */
    public $user;

    /**
     * UserRelationshipObserver constructor.
     *
     * @param  \SAAS\Domain\Users\Models\User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the model "creating" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function creating(Model $model)
    {
        $foreignKey = $this->user->getForeignKey();

        if (!isset($model->{$foreignKey})) {
            $model->setAttribute($foreignKey, $this->user->id);
        }
    }
}
