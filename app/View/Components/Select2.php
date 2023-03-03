<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select2 extends Component
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
     * @var string|null
     */
    public ?string $searchField;
    /**
     * @var boolean
     */
    public bool $required;
    /**
     * @var boolean
     */
    public bool $multiple;
    public string $model;
    public string $primaryField;
    public string $valueField;
    public array|string|null $initialValue;
    public bool $creation;
    public ?array $chainedConfig;

    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($id, $label, $placeholder, $model, $searchField = null,
                                $chainedConfig = null, $initialValue = [], $primaryField = "",
                                $valueField = "", $creation = false, $required = false, $multiple = false)
    {
        $this->id = $id;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->multiple = $multiple;
        $this->model = $model;
        $this->primaryField = $primaryField;
        $this->valueField = $valueField;
        $this->searchField = $searchField;
        $this->creation = $creation;
        $this->initialValue = $initialValue;
        $this->chainedConfig = $chainedConfig;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('components.select2');
    }
}
