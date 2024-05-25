<?php

namespace SAAS\View\Components;

use Illuminate\View\Component;

class SvgIcon extends Component
{
    /**
     * Icon name.
     *
     * @var string
     */
    public $name;

    /**
     * Icon variant.
     *
     * @var string
     */
    public $variant;

    /**
     * Icon size.
     *
     * @var int|string
     */
    public $size;

    /**
     * @var bool|string
     */
    public $toggle;

    /**
     * @var null
     */
    public $optIcon;

    /**
     * Create a new component instance.
     *
     * @param string      $name
     * @param null|string $variant
     * @param int         $shade
     * @param int         $size
     * @param bool|string $toggle
     * @param null|string $optIcon
     */
    public function __construct($name = null, $variant = null, $shade = 500, $size = 24, $toggle = false, $optIcon = null)
    {
        $this->name = $name;
        $this->size = $size;
        $this->variant = !$variant ? null : "text-{$variant}-{$shade}";
        $this->toggle = $toggle;
        $this->optIcon = $optIcon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.svg-icon');
    }
}
