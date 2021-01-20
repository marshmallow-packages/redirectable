<?php

namespace Marshmallow\Redirectable\Traits;

use Illuminate\Database\Eloquent\Model;
use Marshmallow\Redirectable\Models\Redirect;

trait Redirectable
{
    public function redirectable()
    {
        return $this->morphMany(Redirect::class, 'redirectable');
    }
}
