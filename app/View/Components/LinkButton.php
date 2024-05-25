<?php

namespace SAAS\View\Components;

use Illuminate\View\Component;

class LinkButton extends Component
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
     * @var array
     */
    public $resolveClass;

    /**
     * @var string
     */
    public $bgVariant;

    /**
     * @var bool|string
     */
    public $isText;

    /**
     * @var bool|int|string
     */
    public $outline;

    /**
     * @var string
     */
    public $rounded;

    /**
     * @var bool
     */
    public $active;

    /**
     * @var bool|string
     */
    public $ring;

    /**
     * @var bool|string
     */
    public $uppercase;

    /**
     * Create a new component instance.
     *
     * @param  string  $themed
     * @param  string  $variant
     * @param  bool|string  $isText
     * @param  bool  $noPad
     * @param  bool  $noMargin
     * @param  bool  $bold
     * @param  bool|string  $light
     * @param  string  $size
     * @param  bool  $border
     * @param  mixed  $shades
     * @param  mixed  $rounded
     * @param  string  $text
     * @param  string  $outline
     * @param  bool  $active
     * @param  bool|string  $ring
     * @param  bool|string  $uppercase
     * @param  array  $resolveClass
     */
    public function __construct($themed = false, $type = 'submit', $variant = 'blue', $isText = false, $noPad = false, $noMargin = false, $bold = false, $light = false, $size = 'xs', $border = false, $shades = '600,700,800', $rounded = 'none', $text = '', $outline = 'none', $active = false, $ring = false, $uppercase = false, $resolveClass = [])
    {
        $this->themed = $themed;
        $this->shades = explode(',', $shades);
        $this->shades[0] = $shade = $this->shades[0] ?? '600';
        $this->shades[1] = $hoverShade = $this->shades[1] ?? '700';
        $this->shades[2] = $focusShade = $this->shades[2] ?? '800';

        $this->active = $active;

        if ($active) {
            $this->shades[0] = $shade = $this->shades[2];
            $this->shades[1] = $hoverShade = $this->shades[2];
        }

        $this->outline = ((is_numeric($outline) && $outline > 0) || $outline !== 'none') ?
        ("outline-{$outline} outline-{$variant}-{$shades[2]}") : 'focus:outline-none';

        $border = (is_numeric($border)) ? ("border-$border") : ($border ? 'border' : false);

        $this->variant = $variant;
        $this->isText = $isText;
        $this->variantType = $isText ? 'text' : 'bg';
        $textVariant = $text ? $text : $variant;

        $this->textVariant = $light ?
            ($light === 'hover' ? "{$this->variantType}-{$textVariant}-{$shade} hover:text-white focus:text-white" : 'text-white') :
            ("{$this->variantType}-{$textVariant}-{$shade}");

        $this->bgVariant = $light && $this->variantType === 'text' ?
            ($isText === 'outline' ? "hover:bg-{$variant}-{$hoverShade} focus:bg-{$variant}-{$focusShade}" : '') :
            "{$this->variantType}-{$variant}-{$shade}";

        // set bg variant to match "hover" and "focus" shades
        if ($isText === 'outline' && $active) {
            $this->bgVariant = "bg-{$variant}-{$shade} {$this->bgVariant}";
            $this->textVariant = 'text-white';
        }

        // spacing, size
        $this->padding = $noPad ? '' : 'py-2 px-4';
        $this->margin = $noMargin ? '' : 'mx-1 mt-2 md:mt-0';

        // text, font
        $this->bold = $bold ? 'font-semibold' : '';
        $this->uppercase = $uppercase ? 'uppercase' : '';
        $this->size = $size;

        $this->border = $border ? "{$border} border-{$variant}-{$shade} hover:border-{$variant}-{$hoverShade} focus:border-{$variant}-{$focusShade}" : '';
        $this->rounded = "rounded-{$rounded}";

        $ringShade = is_string($ring) ? $ring : $shade;
        $this->ring = $ring === true ? "ring:focus ring-{$variant}-{$ringShade}" : '';

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
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $link = 'components.link-button';

        return view()->exists($link) && $this->themed ? view($link) : view('components.buttons.link-button');
    }

    /**
     * @param $variant
     * @param $border
     * @return string
     */
    public function resolveBorder($variant, $border): string
    {
        $size = is_numeric($border) && $border > 1 ? 'border-'.$border : 'border';

        return $border ? "{$size} border-{$variant}-600 hover:border-{$variant}-700 focus:border-{$variant}-800" : '';
    }
}
