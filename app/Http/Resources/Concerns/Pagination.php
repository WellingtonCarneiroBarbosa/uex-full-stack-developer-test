<?php

namespace App\Http\Resources\Concerns;

trait Pagination
{
    private function getPagination(): array
    {
        return [
            'pagination' => [
                'total'                 => $this->total(),
                'items_on_current_page' => $this->count(),
                'per_page'              => $this->perPage(),
                'current_page'          => $this->currentPage(),
                'last_page'             => $this->lastPage(),
                'from'                  => $this->firstItem(),
                'to'                    => $this->lastItem(),
            ],
        ];
    }
}
