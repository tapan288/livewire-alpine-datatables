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

    public string $sortColumn = 'created_at', $sortDirection = 'desc';

    public function render()
    {
        $query = Student::query();

        $query = $this->applySearch($query);

        $query = $this->applySort($query);

        return view('livewire.list-students', [
            'students' => $query->paginate(10),
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

    public function deleteStudent($studentId)
    {
        Student::find($studentId)->delete();
    }

    public function queryString()
    {
        return [
            'sortColumn',
            'sortDirection',
        ];
    }
}
