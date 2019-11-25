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
    protected $guarded = [];

    /**
     * Always return updated_at as diffForHumans.
     *
     * @param $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }


    /**
     * @param $url
     * @param null $word
     * @return mixed
     */
    public function checkUrl($url, $word = null)
    {
        $query = $this->where('url', $url);
        if ($word){
            $query->orWhere('word', $url);
        }

        return    $query->first();
    }

    /**
     * Visited URL
     *
     * @param $word
     */
    public function visited($word)
    {
        $this->where('word', $word)->increment('visited');
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param mixed $value
     * @return Model|null
     */
    /*public function resolveRouteBinding($value)
    {
        return $this;
    }*/
}
