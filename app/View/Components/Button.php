<?php

namespace SAAS\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    /**
     * @var bool
     */
    public $themed;

    /**
     * @var string
     */
    public $variant;

    /**
     * @var bool
     */
    public $variantType;

    /**
     * @var bool
     */
    public $padding;

    /**
     * @var bool
     */
    public $bold;

    /**
     * @var string
     */
    public $textVariant;

    /**
     * @var string|array
     */
    public $shades;

    /**
     * @var string
     */
    public $margin;

    /**
     * @var string
     */
    public $size;

    /**
     * @var bool
     */
    public $border;

    /**
     * @var string
     */
    public $conditionalClasses;

    /**
     * @var string
     */
    public $bgVariant;

    /**
     * @var bool|string
     */
    public $isText;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $rounded;

    /**
     * Create a new component instance.
     *
     * @param  string  $type
     * @param  string  $rounded
     * @param  string  $variant
     * @param  bool|string  $isText
     * @param  bool  $noPad
     * @param  bool  $noMargin
     * @param  bool  $bold
     * @param  bool  $light
     * @param  string  $size
     * @param  bool  $border
     * @param  array  $resolveClass
     */
    public function __construct($themed = false, $type = 'submit', $variant = 'blue', $isText = false, $noPad = false, $noMargin = false, $bold = false, $light = false, $size = 'xs', $border = false, $shades = '600,700,800', $rounded = 'md', $resolveClass = [])
    {
        $this->themed = $themed;
        $this->shades = explode(',', $shades);
        $this->shades[0] = $shade = $this->shades[0] ?? '600';
        $this->shades[1] = $hoverShade = $this->shades[1] ?? '700';
        $this->shades[2] = $focusShade = $this->shades[2] ?? '800';

        $border = (is_numeric($border)) ? ("border-$border") : ($border ? 'border' : false);

        $this->variant = $variant;
        $this->isText = $isText;
        $this->variantType = $isText ? 'text' : 'bg';

        $this->textVariant = $light ? ($light === 'hover' ?
            "{$this->variantType}-{$variant}-{$shade} hover:text-white focus:text-white" : 'text-white') :
            ("{$this->variantType}-{$variant}-{$shade}");

        $this->bgVariant = $light && $this->variantType === 'text' ?
            ($isText === 'outline' ? "hover:bg-{$variant}-{$hoverShade} focus:bg-{$variant}-{$focusShade}" : '') :
            "{$this->variantType}-{$variant}-{$shade}";

        // spacing, size
        $this->padding = $noPad ? '' : 'py-2 px-4';
        $this->margin = $noMargin ? '' : 'mx-1 mt-2 md:mt-0';

        // text, font
        $this->bold = $bold ? 'font-semibold' : '';
        $this->size = $size;

        $this->border = $border ? "{$border} border-{$variant}-{$shade} hover:border-{$variant}-{$hoverShade} focus:border-{$variant}-{$focusShade}" : '';

        $this->type = $type;
        $this->rounded = $rounded;

        $conditionalClasses = [];

        foreach ($resolveClass as $key => $class) {
            if (! empty($class)) {
                $conditionalClasses[] = $key;
            }
        }
        $this->conditionalClasses = implode(' ', $conditionalClasses);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
