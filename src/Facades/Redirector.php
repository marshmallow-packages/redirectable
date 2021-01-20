<?php

namespace Marshmallow\Redirectable\Facades;

class Redirector extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return \Marshmallow\Redirectable\Redirector::class;
    }
}
