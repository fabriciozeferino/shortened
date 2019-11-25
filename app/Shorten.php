<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static select(array $array)
 * @method static where(string $string, $urlRequest)
 * @property mixed word
 * @property mixed url
 */
class Shorten extends Model
{
    protected $table = 'shortens';

    protected $guarded = [];


    /**
     * @param $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        return $this;
    }
}
