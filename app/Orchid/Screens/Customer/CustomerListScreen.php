<?php

namespace App\Orchid\Screens\Customer;

use App\Models\Company;
use App\Orchid\Layouts\Customer\CustomerListLayout;
use Orchid\Screen\Screen;

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
            'customers' => Company::withCount(['users'])
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
            CustomerListLayout::class
        ];
    }
}
