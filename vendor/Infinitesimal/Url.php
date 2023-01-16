<?php

namespace Infinitesimal;

class Url
{
    private static $projectUrl;

    public static function init(string $projectUrl)
    {
        self::$projectUrl = $projectUrl;
    }

    public static function projectUrl()
    {
        return self::$projectUrl;
    }

    public static function get(string $url, array $params = [])
    {
        if (strlen($url) > 0 && substr($url, 0, 1) === '/')
            $fullUrl = self::$projectUrl . $url;
        else
            $fullUrl = $url;

        $fullUrl = self::setParams($fullUrl, $params);
        return $fullUrl;
    }

    public static function getBack(array $params = [])
    {
        return self::getBackOr('/', $params);
    }

    public static function getBackOr(string $fallbackUrl, array $params = [])
    {
        return isset($_SERVER['HTTP_REFERER']) ? self::get($_SERVER['HTTP_REFERER'], $params) : self::get($fallbackUrl);
    }

    public static function redirect($url, array $params = [])
    {
        $redirectUrl = self::get($url, $params);
        header("Location: $redirectUrl");
        exit();
    }

    public static function redirectBack(array $params = [])
    {
        self::redirect(self::getBack(), $params);
    }

    public static function resource($path)
    {
        return self::$projectUrl . "/Resources/$path";
    }

    private static function setParams(string $url, array $paramsToSet)
    {
        if ($paramsToSet === []) return $url;

        $urlParts = explode('?', $url);
        $url = $urlParts[0];
        $queryString = sizeof($urlParts) > 1 ? $urlParts[1] : '';
        parse_str($queryString, $existingParams);

        $outputParams = array_merge($existingParams, $paramsToSet);

        $queryString = sizeof($outputParams) > 0 ? '?' . http_build_query($outputParams) : '';
        return $url . $queryString;
    }
}