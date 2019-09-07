<?php

namespace App\Models;

use TCG\Voyager\Traits\Resizable;

class Slider extends BaseEloquentModel
{
    use Resizable;

    public function displayLink()
    {
        $domains = config('site.domains');
        $siteDomain = $_SERVER['HTTP_HOST'];
        $urlParsed = parse_url($this->link);
        if (!empty($urlParsed['host']) && in_array($urlParsed['host'], $domains) && $urlParsed['host'] != $siteDomain) {
            return str_replace($urlParsed['host'], $siteDomain, $this->link);
        }

        return $this->link;
    }
}
