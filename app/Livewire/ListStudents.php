<?php

namespace App\Livewire;

use App\Models\Student;
use App\Traits\Sortable;
use Livewire\Component;
use App\Traits\Searchable;
use Livewire\WithPagination;
use App\Exports\StudentsExport;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class ListStudents extends Component
{
    use WithPagination, Searchable, Sortable;

    public array $selectedStudentIds = [],
    $studentIdsOnPage = [],
    $allStudentIds = [];

    public function render()
    {
        $query = Student::query();

        $query = $this->applySearch($query);

        $query = $this->applySort($query);

        $this->allStudentIds = $query->
            pluck('id')
            ->map(fn($id) => (string) $id)
            ->toArray();

        $students = $query->paginate(5);

        $this->studentIdsOnPage = $students
            ->map(fn($student) => (string) $student->id)
            ->toArray();

        return view('livewire.list-students', [
            'students' => $students,
        ]);
    }

    public function deleteStudent(Student $student)
    {
        // Authorization check

        $student->delete();
    }

    public function deleteStudents()
    {
        $students = Student::find($this->selectedStudentIds);

        foreach ($students as $student) {
            $this->deleteStudent($student);
        }

        Notification::make()
            ->title('Selected Records deleted Successfully')
            ->success()
            ->send();
    }

    public function export()
    {
        return (new StudentsExport($this->selectedStudentIds))
            ->download(now() . ' - students.xlsx');
    }
}
