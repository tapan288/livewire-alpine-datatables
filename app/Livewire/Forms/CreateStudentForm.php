<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Section;
use App\Models\Student;
use Livewire\Attributes\Validate;

class CreateStudentForm extends Form
{
    #[Validate('required')]
    public $name;

    #[Validate('required|email|unique:students,email')]
    public $email;

    #[Validate('required')]
    public $section_id;

    public $sections = [];

    public function storeStudent($class_id)
    {
        Student::create([
            'name' => $this->name,
            'email' => $this->email,
            'class_id' => $class_id,
            'section_id' => $this->section_id,
        ]);
    }

    public function setSections($class_id)
    {
        $this->sections = Section::where('class_id', $class_id)->get();
    }
}
