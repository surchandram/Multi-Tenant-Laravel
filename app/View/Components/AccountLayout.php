<?php

namespace SAAS\View\Components;

use Illuminate\View\Component;

class AccountLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('account.layouts.default');
    }
}
