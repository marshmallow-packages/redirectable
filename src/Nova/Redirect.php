<?php

namespace Marshmallow\Redirectable\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\MorphTo;
use Marshmallow\Pages\Nova\Page;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Marshmallow\Redirectable\Models\Redirect';

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
     * @param \Illuminate\Http\Request $request Request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            MorphTo::make(__('Redirectable'), 'redirectable')->types(
                config('redirectable.types')
            )->nullable(),
            Text::make(__('Redirect this'), 'redirect_this')->rules('required'),
            Text::make(__('To this'), 'to_this')->rules('required'),
            Select::make(__('HTTP code'), 'http_code')->options(
                config('redirectable.http_codes')
            )->rules('required'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
