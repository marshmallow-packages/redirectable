<?php

namespace Marshmallow\Redirectable\Nova;

use App\Nova\Resource;
use Laravel\Nova\Tabs\Tab;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class Redirect extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Marshmallow\Redirectable\Models\Redirect';

    public static $group_icon = '<svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path fill="var(--sidebar-icon)" d="M3 2v12h3v9l7-12H9l4-9H3zm16 0h-2l-3.2 9h1.9l.7-2h3.2l.7 2h1.9L19 2zm-2.15 5.65L18 4l1.15 3.65h-2.3z"/></svg>';

    public static function group()
    {
        return __('SEO');
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'redirect_this';

    public static function label()
    {
        return __('Redirect');
    }

    public static function singularLabel()
    {
        return __('Redirect');
    }

    public function title()
    {
        return __('Redirect: ') . $this->redirect_this;
    }

    public function subtitle()
    {
        return __('To: ') . $this->to_this;
    }


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'redirect_this',
        'to_this',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request NovaRequest
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Tab::group(__('Redirect Details'), [
                Tab::make(__('Basic Information'), [
                    Text::make(__('Redirect this'), 'redirect_this')->rules('required'),
                    Text::make(__('To this'), 'to_this')->rules('required'),
                    Select::make(__('HTTP code'), 'http_code')->options(
                        config('redirectable.http_codes')
                    )->rules('required'),
                ]),
                Tab::make(__('Association'), [
                    MorphTo::make(__('Redirectable'), 'redirectable')->types(
                        config('redirectable.types')
                    )->nullable(),
                ]),
            ]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
