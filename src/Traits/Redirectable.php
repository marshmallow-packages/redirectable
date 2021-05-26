<?php

namespace Marshmallow\Redirectable\Traits;

trait Redirectable
{
    public function redirectable()
    {
        return $this->morphMany(config('redirectable.models.redirect'), 'redirectable');
    }
}
