<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class AppLayout extends Component
{
    public $categories;
    public $class;
    public $small;

    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct(EloquentCollection $categories,$class = '',$smallClass = '')
    {
        $this->categories = $categories;
        $this->class = $class;
        $this->small = $smallClass;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.app');
    }
}
