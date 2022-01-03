<?php

namespace App\Orchid\Screens\License;

use App\Models\LicenseType;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class LicenseEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Create license';
    public $description = 'Generate new license';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Select::make('licenseType')
                    ->fromModel(LicenseType::class, 'name', 'id')
                    ->title('License type'),
                Button::make('Generate license')
                    ->method('generate')
            ])
        ];
    }

    public function generate(Request $request)
    {
        dd($request->all());
    }
}
