<?php

namespace App\Orchid\Layouts\License;

use App\Models\License;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
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
            TD::make('license_type_id', 'Type')->render(function (License $license) {
                return $license->licenseType->name;
            })->sort(),
            TD::make('status', 'Status'),
            TD::make('created_at', 'Created'),
            TD::make('updated_at', 'Last edit'),
            TD::make('status', '')->render(function (License $license) {

                if ($license->status == 'pending') {
                    return Button::make('Mark as payed!')->confirm(__('Are you sure you want to delete the user?'))
                        ->icon('dollar')
                        ->method('buy')->rawClick()
                        ->novalidate();
                }

                return $license->status;
            }),
        ];
    }
}
