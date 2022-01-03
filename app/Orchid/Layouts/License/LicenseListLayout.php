<?php

namespace App\Orchid\Layouts\License;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LicenseListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'licenses';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('key', 'Key'),
            TD::make('desk', 'Desk'),
            TD::make('type.name', 'Type'),
            TD::make('status', 'Status'),
            TD::make('created_at', 'Created'),
            TD::make('updated_at', 'Last edit'),
            TD::make('status', '')->render(function ($license) {
                return $license->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
            }),
        ];
    }
}
