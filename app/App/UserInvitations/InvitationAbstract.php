<?php

namespace SAAS\App\UserInvitations;

use Illuminate\Database\Eloquent\Model;
use SAAS\Domain\Users\Models\UserInvitation;

abstract class InvitationAbstract implements \SAAS\App\UserInvitations\UserInvitation
{
    protected $fillable = [];

    protected $data = [];

    protected ?Model $roleable = null;

    protected ?Model $referable = null;

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    public function setFillable(array $data)
    {
        $this->fillable = array_merge($this->fillable, $data);

        return $this;
    }

    /**
     * @return array
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getRoleable()
    {
        return $this->roleable;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getReferable()
    {
        return $this->referable;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $referable
     */
    public function withReferable($referable)
    {
        $this->referable = $referable;

        return $this;
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
     */
    public function withData($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $index => $value) {
                $this->data[$index] = $value;
            }
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Get the invitation type.
     *
     * @return string
     */
    protected function getType()
    {
        return property_exists($this, 'type') ? $this->type : get_class($this);
    }

    /**
     * Stores and queues the invitation to be sent.
     *
     * @return \SAAS\Domain\Users\Models\UserInvitation
     */
    public function send()
    {
        $invitation = new UserInvitation();

        $invitation->fill($this->getFillable());

        $invitation->type = $this->getType();

        $invitation->data = $this->getData();

        $invitation->referable()->associate($this->getReferable());

        if ($this->getRoleable()) {
            $invitation->roleable()->associate($this->getRoleable());
        }

        $invitation->save();

        return $invitation;
    }
}
