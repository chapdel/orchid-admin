<?php

namespace App\Orchid\Screens\Customer;

use App\Models\Company;
use App\Orchid\Layouts\Customer\CustomerListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CustomerListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Customer';
    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'All registered customers';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'customers' => Company::with(['license'])
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
            ModalToggle::make('New customer')
                ->modal('newCustomer')
                ->method('newCustomer')
                ->icon('pencil'),

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
            CustomerListLayout::class,
            Layout::modal('newCustomer', [
                Layout::rows([
                    Input::make('name')
                        ->type('text')
                        ->max(255)
                        ->required()
                        ->title(__('Name'))
                        ->placeholder(__('Name')),
                    Input::make('email')
                        ->type('text')
                        ->max(255)
                        ->title(__('Email'))
                        ->placeholder(__('Email')),
                    Input::make('phone')
                        ->type('text')
                        ->max(255)
                        ->required()
                        ->title(__('Phone'))
                        ->placeholder(__('Phone')),
                ]),
            ])->title('New customer')->applyButton('Save')
                ->closeButton('Cancel'),
        ];
    }

     /**
     * The action that will take place when
     * the form of the modal window is submitted
     */
    public function newCustomer(Request $request): void
    {

        $request->validate([
            'email' => ['nullable', 'unique:companies'],
            "phone" => ['required', 'unique:companies'],
            "name" => ['required'],
        ]);

        Company::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
        ]);

        Toast::success('Hello you just created a new customer');
    }
}
