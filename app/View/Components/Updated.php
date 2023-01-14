<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Updated extends Component

{

    /**
     * created date
     * 
     * @var date
     */
    public $date;

    /**
     * updated name
     * 
     * @var name;
     */
    public $name;

    /**
     * updated date
     * 
     * @var edited
     */
    public $edited;

    /**
     * user id
     * 
     * @var userId
     */
    public $userId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($date = null, $name = null, $edited = null, $userId = null)
    {
        $this->date = $date;
        $this->name = $name;
        $this->edited = $edited;
        $this->userId = $userId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.updated');
    }
}