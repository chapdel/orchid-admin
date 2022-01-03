<?php

namespace App\Orchid\Screens\License;

use App\Orchid\Layouts\License\LicenseTypeListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class LicenseTypeListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'License types';

    public $description = "All available licenses types";

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'licenseTypes' => \App\Models\LicenseType::withCount([])
                ->paginate(),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create new')
                ->icon('pencil')
                ->route('platform.licenses.types.create')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            LicenseTypeListLayout::class
        ];
    }
}
