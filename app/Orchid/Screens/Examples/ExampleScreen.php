<?php

namespace App\Orchid\Screens\Examples;

use App\Models\License;
use App\Models\User;
use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartLineExample;
use App\Orchid\Layouts\Examples\MetricsExample;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ExampleScreen extends Screen
{
    /**
     * Fish text for the table.
     */
    public const TEXT_EXAMPLE = 'Lorem ipsum at sed ad fusce faucibus primis, potenti inceptos ad taciti nisi tristique
    urna etiam, primis ut lacus habitasse malesuada ut. Lectus aptent malesuada mattis ut etiam fusce nec sed viverra,
    semper mattis viverra malesuada quam metus vulputate torquent magna, lobortis nec nostra nibh sollicitudin
    erat in luctus.';

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Dashboard';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'All the important metrics';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {

        $licenses = License::with(['licenseType'])->whereNotIn('status', ['pending', 'canceled'])
            ->get();

        $license_sales = [];
         $license_charts = [];

        foreach ($licenses->groupBy('licenseType.name') as $key => $value) {
            $values = [];
            $valuess = [];
            $dates = [];

            for ($i = 0; $i < 30; $i++) {
                $values[] = $value->whereBetween('created_at', [now()->subDays($i)->startOfDay(), now()->subDays($i)->endOfDay()])->count();

                $valuess[] = $value->whereBetween('created_at', [now()->subDays($i)->startOfDay(), now()->subDays($i)->endOfDay()])->sum('price');
                $dates[] = now()->subDays($i)->format('d M');
            }
            $license_charts[] = [
                'name' => $key,
                'values' =>  array_reverse($values),
                'labels' => array_reverse($dates)
            ];

            $license_sales[] = [
                'name' => $key,
                'values' => array_reverse($valuess),
                'labels' => array_reverse($dates),
            ];
        }
        return [
            'charts'  => $license_charts,
            'sales'  => $license_sales,
            'metrics' => [
                ['keyValue' => number_format(User::weekSales(), 0), 'keyDiff' => 0],
                ['keyValue' => number_format(License::whereNotIn('status', ['pending', 'expired', 'canceled'])->count(), 0), 'keyDiff' => 0],
                ['keyValue' => number_format(License::whereStatus('pending')->count(), 0), 'keyDiff' => 0],
                ['keyValue' => number_format(User::totalSales(), 0), 'keyDiff' => 0],
            ],
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

            /* Button::make('Show toast')
                ->method('showToast')
                ->novalidate()
                ->icon('bag'),

            ModalToggle::make('Launch demo modal')
                ->modal('exampleModal')
                ->method('showToast')
                ->icon('full-screen'),

            Button::make('Export file')
                ->method('export')
                ->icon('cloud-download')
                ->rawClick()
                ->novalidate(),

            DropDown::make('Dropdown button')
                ->icon('folder-alt')
                ->list([

                    Button::make('Action')
                        ->method('showToast')
                        ->icon('bag'),

                    Button::make('Another action')
                        ->method('showToast')
                        ->icon('bubbles'),

                    Button::make('Something else here')
                        ->method('showToast')
                        ->icon('bulb'),
                ]), */];
    }

    /**
     * Views.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            MetricsExample::class,

            ChartLineExample::class,
            ChartBarExample::class,
        ];
    }

    /**
     * @param Request $request
     */
    public function showToast(Request $request): void
    {
        Toast::warning($request->get('toast', 'Hello, world! This is a toast message.'));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        return response()->streamDownload(function () {
            $csv = tap(fopen('php://output', 'wb'), function ($csv) {
                fputcsv($csv, ['header:col1', 'header:col2', 'header:col3']);
            });

            collect([
                ['row1:col1', 'row1:col2', 'row1:col3'],
                ['row2:col1', 'row2:col2', 'row2:col3'],
                ['row3:col1', 'row3:col2', 'row3:col3'],
            ])->each(function (array $row) use ($csv) {
                fputcsv($csv, $row);
            });

            return tap($csv, function ($csv) {
                fclose($csv);
            });
        }, 'File-name.csv');
    }
}
