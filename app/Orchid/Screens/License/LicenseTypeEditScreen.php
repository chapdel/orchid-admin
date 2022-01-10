<?php

namespace App\Orchid\Screens\License;

use App\Models\LicenseType;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Radio;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class LicenseTypeEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Edit License Type';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Details such as name, price, etc.';

    /**
     * @var LicenseType
     */
    private $licenseType;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(LicenseType $licenseType): array
    {

        $this->licenseType = $licenseType;

        if (!$licenseType->exists) {
            $this->name = 'Create License Type';
        }

        return [
            'licenseType'  => $licenseType,
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
            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once the license is deleted, all of its resources and data will be permanently deleted. Are you sure you want to delete it?'))
                ->method('remove')
                ->canSee($this->licenseType->exists),

            Button::make(__('Save'))
                ->icon('check')
                ->method('createOrUpdate'),
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
            Layout::rows([
                Input::make('licenseType.name')
                    ->title('Name')
                    ->placeholder('License name')
                    ->help('Specify a short descriptive name for this type.'),
                Select::make('licenseType.period')
                    ->options([
                        'annually'   => 'Annually',
                        'lifetime'   => 'Lifetime',
                    ])
                    ->title('Period')
                    ->help('Period of validity'),
                Select::make('licenseType.desk')
                    ->options([
                        '2'   => '2 users',
                        '5'   => '3-5 users',
                        '10'   => '6-10 users',
                        '20'   => '11-20 users',
                        '21'   => '+21 users',
                    ])
                    ->title('Users')
                    ->help('Number of stations'),
                Input::make('licenseType.price')
                    ->title('Price')
                    ->mask([
                        'alias' => 'currency',
                        'suffix' => ' FCFA',
                        'groupSeparator' => ' ',
                        'numericInput' => true,
                        'digitsOptional' => false,
                    ]),
                CheckBox::make('licenseType.cloud')
                    ->value(false)
                    ->title('Features')->placeholder("Enable Cloud backup"),
                CheckBox::make('licenseType.notification')
                    ->value(false)->placeholder("Enable Notifications"),
                TextArea::make('licenseType.description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Brief description for preview'),

            ])
        ];
    }

    /**
     * @param LicenseType    $post
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(LicenseType $licenseType, Request $request)
    {
        $request->validate([
            'licenseType.price' => ['required'],
            'licenseType.name' => ['required'],
        ]);

        $data = $request->get('licenseType');

        $data['notification'] = $data['notification'] == 'on';
        $data['cloud'] = $data['cloud'] == 'on';
        $licenseType->fill($data)->save();

        Alert::info('You have successfully created an license type.');

        return redirect()->route('platform.licenses.types');
    }
}
