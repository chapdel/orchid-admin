<?php

namespace App\Orchid\Screens\License;

use App\Models\License;
use App\Models\LicenseType;
use App\Orchid\Layouts\License\LicenseListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class LicenseListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'License';

    public $description = "All created licenses";

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'licenses' => \App\Models\License::with(['licenseType'])->paginate(),
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
            ModalToggle::make('New license')
                ->modal('newLicense')
                ->method('newLicense')
                ->icon('pencil')
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
            LicenseListLayout::class,
            Layout::modal('newLicense', [
                Layout::rows([
                    Select::make('licenseType')
                        ->fromModel(LicenseType::class, 'name', 'id')
                        ->title('License type'),
                ]),
            ])->title('Generate new license')->applyButton('Generate')
                ->closeButton('Cancel'),
        ];
    }


    /**
     * The action that will take place when
     * the form of the modal window is submitted
     */
    public function newLicense(Request $request): void
    {

        License::create([
            'license_type_id' => $request->get('licenseType'),
        ]);
        Toast::success('Hello you just generated a new license');
    }
}
