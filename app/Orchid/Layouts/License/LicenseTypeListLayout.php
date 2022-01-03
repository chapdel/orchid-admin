<?php

namespace App\Orchid\Layouts\License;

use App\Models\LicenseType;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LicenseTypeListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'licenseTypes';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('name', 'Name'),
            TD::make('desk', 'Desk'),
            TD::make('notification', 'Notification'),
            TD::make('cloud', 'Cloud backup'),
            TD::make('price', 'Price'),
            //TD::make('users_count', 'Users'),
            TD::make('created_at', 'Created'),
            TD::make('updated_at', 'Last edit'),
        ];
    }
}
