<?php
namespace T3sec\Url;


class UrlNormalizer
{
    /**
     * @var  string|null
     */
    protected $originUrl = NULL;


    public function __construct()
    {
        $this->reset();
    }

    /**
     * @param  string  $originUrl
     * @return  UrlNormalizer  class instance
     */
    public function setOriginUrl($originUrl)
    {
        $this->originUrl = $originUrl;
        return $this;
    }

    /**
     * @return  string|null
     */
    public function getOriginUrl()
    {
        return $this->originUrl;
    }

    /**
     * @return  array  normalized URL
     */
    public function getNormalizedUrl()
    {
        $regex = '#^([a-zA-Z0-9\.\-]*://)*([\w\.\-\d]*)(:(\d+))*(/*)([^:]*)$#';
        $matches = array();
        preg_match($regex, $this->originUrl, $matches);

        $urlInfo['protocol'] = $matches[1];
        $urlInfo['port'] = $matches[4];
        $urlInfo['host'] = $matches[2];
        $urlInfo['path'] = $matches[6];

        if (empty($urlInfo['protocol'])) {
            $urlInfo['protocol'] = 'http://';
        }

        $patterns = array();
        $patterns[0] = '#fileadmin#';
        $patterns[1] = '#//#';
        $replacements = array();
        $replacements[0] = '';
        $replacements[1] = '/';
        $urlInfo['path'] = preg_replace($patterns, $replacements, $urlInfo['path']);

        if (!empty($urlInfo['path']) && $urlInfo['path'] == '/') {
            $urlInfo['path'] = '';
        }

        return $urlInfo;
    }

    /**
     * @return  void
     */
    public function reset()
    {
        $this->originUrl = NULL;
    }
}