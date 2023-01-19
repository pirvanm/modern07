<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

use Intranet\ShowProposal\ShowProposal;

class Proposal extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Proposal>
     */
    public static $model = \App\Models\Proposal::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $statuses = \App\Enums\ProposalStatuses::toArray();
        $types = \App\Enums\ShopTypes::toArray();

        return [
            ID::make()->sortable(),
            BelongsTo::make('User', )->onlyOnIndex(),

            Select::make('Type', 'type', function ($type) use ($types) {
                return array_search($type, $types);
            })->options($types),

            Select::make('Status', null, function ($status) use ($statuses) {
                return array_search($status, $statuses);
            })->options($statuses),

            ShowProposal::make()->setData($this->model()),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    public static function availableForNavigation(Request $request)
    {
        return $request->user()->can('proposal_index');
    }
}
