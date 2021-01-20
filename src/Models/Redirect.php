<?php

namespace Marshmallow\Redirectable\Models;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $guarded = [];

    public function getFinalRedirect()
    {
        $next_found = self::where('redirect_this', $this->to_this)->first();
        if ($next_found) {
            return $next_found->getFinalRedirect();
        }
        return $this;
    }

    public function redirectable()
    {
        return $this->morphTo('redirectable');
    }
}
