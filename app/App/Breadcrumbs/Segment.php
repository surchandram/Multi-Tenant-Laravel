<?php

namespace SAAS\App\Breadcrumbs;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Segment
{
    /**
     * Request.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var $segment
     */
    protected $segment;

    /**
     * Segment constructor.
     *
     * @param \Illuminate\Http\Request $request
     * @param $segment
     * @return void
     */
    public function __construct(Request $request, $segment)
    {
        $this->request = $request;
        $this->segment = $segment;
    }

    /**
     * Get a readable segment's name.
     *
     * @return string
     */
    public function name()
    {
        return Str::title($this->segment);
    }

    /**
     * Get the segment's model from route parameters.
     *
     * @return mixed
     */
    public function model()
    {
        return collect($this->request->route()->parameters())->where($this->getModelKey(), $this->segment)->first();
    }

    /**
     * Get segment's url.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function url()
    {
        return url(
            implode(array_slice($this->request->segments(), 0, $this->position() + 1), '/')
        );
    }

    /**
     * Get segment's position.
     *
     * @return false|int|string
     */
    public function position()
    {
        return array_search($this->segment, $this->request->segments());
    }

    /**
     * Determine segment's model route key from route parameters.
     *
     * @return string
     */
    public function getModelKey()
    {
        if ($key = array_search($this->segment, $this->request->route()->originalParameters())) {
            $parameter = $this->request->route()->parameter($key);

            if(is_object($parameter)){
                $model = get_class($parameter);

                return (new $model)->getRouteKeyName();
            }
        }

        return 'slug';
    }
}
