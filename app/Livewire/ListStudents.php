<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class ListStudents extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.list-students', [
            'students' => Student::paginate(),
        ]);
    }
}
