<?php

namespace App\Livewire;

use App\Models\Classes;
use Livewire\Component;
use Livewire\Attributes\Validate;

class CreateStudent extends Component
{
    #[Validate('required')]
    public $name;

    #[Validate('required|email|unique:students,email')]
    public $email;

    #[Validate('required')]
    public $class_id;

    #[Validate('required')]
    public $section_id;

    public function addStudent()
    {
        $this->validate();

        dd('sdnbcsndb');
    }

    public function render()
    {
        return view('livewire.create-student', [
            'classes' => Classes::all(),
        ]);
    }
}
