<?php

namespace SAAS\View\Components;

use Illuminate\View\Component;

class TableColHead extends Component
{
    /**
     * @var bool
     */
    public $bordered;

    /**
     * Create a new component instance.
     *
     * @param  bool $bordered
     * @return void
     */
    public function __construct($bordered = false)
    {
        $this->bordered = $bordered;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table-col-head');
    }
}
