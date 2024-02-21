<?php

namespace App\Traits;

use Livewire\Attributes\Url;
use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    #[Url]
    public string $sortColumn = 'created_at';

    #[Url]
    public $sortDirection = 'desc';

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
}
