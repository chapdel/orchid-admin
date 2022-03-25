<?php

namespace App\Orchid\Layouts\Customer;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CustomerListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'customers';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('code', 'Account ID'),
            TD::make('name', 'Name')
            /* ->render(function (Post $post) {
                return Link::make($post->title)
                    ->route('platform.post.edit', $post);
            }) */,
            TD::make('email', 'Email'),
            TD::make('phonet', 'Phone'),
            TD::make('created_at', 'Created'),
        ];
    }
}
