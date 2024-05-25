<?php

namespace SAAS\View\Components;

use Illuminate\View\Component;

class Alerts extends Component
{
    /**
     * @var array
     */
    public $types = [
        'success' => 'teal',
        'error' => 'red',
        'warning' => 'yellow',
        'info' => 'blue',
    ];

    /**
     * @var bool
     */
    public $multipleAlerts = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->checkIfMultipleAlertsFired();
    }

    public function checkIfMultipleAlertsFired(): void
    {
        $this->multipleAlerts = count(session()->only(array_keys($this->types))) > 1;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alerts');
    }
}
