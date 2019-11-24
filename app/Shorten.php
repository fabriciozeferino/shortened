<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static select(array $array)
 * @method static where(string $string, $urlRequest)
 */
class Shorten extends Model
{
    protected $table = 'shortens';
    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        return $this->where('word', $value)->first() ?? abort(404);
    }
}
