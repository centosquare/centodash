<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CentoDashInput extends Component
{
    public $type;
    public $name;
    public $label;
    public $placeholder;
    public $message;
    public $value;
    public $options;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $name = null, $label = null, $placeholder = "", $message = "", $value = null, $options = [])
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->message = $message;
        $this->value = $value;
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cento-dash-input');
    }
}
