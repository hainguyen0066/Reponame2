<?php

class LocalValetDriver extends LaravelValetDriver
{
    protected $htmlDirs = [
        'html'
    ];
    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        foreach ($this->htmlDirs as $dir) {
            if ((strlen($uri) - strlen($dir) > 1)
                && strpos($uri, '/' . $dir) == 0
                && file_exists($staticFilePath = $sitePath . $uri)
            ) {
                return $staticFilePath;
            }
        }
        return parent::isStaticFile($sitePath, $siteName, $uri);
    }
}
