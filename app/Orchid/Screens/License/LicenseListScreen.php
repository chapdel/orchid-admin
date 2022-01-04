<?php

namespace App\Orchid\Screens\License;

use App\Models\License;
use App\Models\LicenseType;
use App\Orchid\Layouts\License\LicenseListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
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
            Layout::table('licenses', [
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
                            ->novalidate()
                            ->parameters(['id' => $license->id]);
                    }

                    return $license->status;
                }),
            ]),
            Layout::modal('newLicense', [
                Layout::rows([
                    Select::make('licenseType')
                        ->fromModel(LicenseType::class, 'name', 'id')
                        ->title('License type'),
                    Select::make('status')
                        ->options([
                            'pending' => "Pending",
                            'payed' => "Payed"
                        ])
                        ->title('Status'),
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
            'status' => $request->get('status')
        ]);
        Toast::success('Hello you just generated a new license');
    }

    public function buy()
    {
        $license = License::find(request()->get('id'))->update(['status' => 'payed']);

        Toast::success('Hello you just saled license');
    }
}
