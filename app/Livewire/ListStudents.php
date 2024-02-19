<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\StudentsExport;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class ListStudents extends Component
{
    use WithPagination;

    public string $search = '';

    public string $sortColumn = 'created_at', $sortDirection = 'desc';

    public array $selectedStudentIds = [], $studentIdsOnPage = [];

    public function render()
    {
        $query = Student::query();

        $query = $this->applySearch($query);

        $query = $this->applySort($query);

        $students = $query->paginate(5);

        $this->studentIdsOnPage = $students->map(fn($student) => (string) $student->id)->toArray();

        return view('livewire.list-students', [
            'students' => $students,
        ]);
    }

    protected function applySort(Builder $query): Builder
    {
        return $query->orderBy($this->sortColumn, $this->sortDirection);
    }

    public function sortBy(string $column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
            $this->sortColumn = $column;
        }
    }

    public function applySearch(Builder $query): Builder
    {
        return $query->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%');
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
        return (new StudentsExport($this->selectedStudentIds))->download(now() . ' - students.xlsx');
    }

    public function queryString()
    {
        return [
            'sortColumn',
            'sortDirection',
        ];
    }
}
