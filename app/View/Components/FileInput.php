<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileInput extends Component
{
    /**
     * @var string
     */
    public string $id;
    /**
     * @var string
     */
    public string $label;
    /**
     * @var string
     */
    public string $placeholder;
    /**
     * @var boolean
     */
    public bool $required;
    /**
     * @var boolean
     */
    public bool $multiple;
    public array|String|null $initialValue;
    public array $extensions;
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($id, $label, $placeholder, $initialValue=null, $creation=false, $required = false,
                                $multiple = false, $extensions=['pdf'])
    {
        $this->id = $id;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->multiple = $multiple;
        $this->initialValue = $initialValue;
        $this->extensions = $extensions;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('components.file-input');
    }
}
