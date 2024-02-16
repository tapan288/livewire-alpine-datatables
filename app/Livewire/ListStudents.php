<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class ListStudents extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $query = Student::query();

        $query = $this->applySearch($query);

        return view('livewire.list-students', [
            'students' => $query->paginate(10),
        ]);
    }

    public function applySearch(Builder $query)
    {
        return $query->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%');
    }

    public function deleteStudent($studentId)
    {
        Student::find($studentId)->delete();
    }
}
