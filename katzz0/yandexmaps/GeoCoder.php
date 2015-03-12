<?php

namespace katzz0\yandexmaps;

use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Class GeoCoder
 *
 * Component for geocoding by http request
 */
class GeoCoder extends Component
{
    /**
     * @var string Protocol for the requests, if not specified the detected
     * by \Yii::$app->getRequest()->isSecureConnection
     */
    public static $protocol;

    /**
     * @var string Uri for the http geocode api
     */
    public static $uri = 'geocode-maps.yandex.ru';

    /**
     * @var string Version of the api
     */
    public static $version = '1.x';

    /**
     * @var array curl params
     */
    protected static $CURL_OPTS = [
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_USERAGENT => 'yii2-yandex-maps'
    ];

    /**
     * Find coordinates of the first matched object
     * @param string $objectName
     * @param array $params Different params for the request
     * @return array|null
     */
    public static function findFirst($objectName, array $params = [])
    {
        $params['geocode'] = $objectName;
        $result = self::makeRequest($params);

        if (isset($result['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'])) {
            return explode(
                ' ',
                $result['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']
            );
        }

        return null;
    }

    /**
     * Returns the template url for different requests
     * @return string
     */
    private static function prepareRequestUrl()
    {
        $protocol = self::$protocol ?: (\Yii::$app->getRequest()->isSecureConnection ? 'https' : 'http');
        return $protocol.'://'.self::$uri.'/'.self::$version.'/?';
    }

    /**
     * Make request to the geocoder api
     * @param array $params
     * @return array|null
     * @throws InvalidConfigException
     */
    private static function makeRequest(array $params)
    {
        if (!function_exists('curl_version')) {
            throw new InvalidConfigException('Extension curl not found');
        }

        $ch = curl_init();

        $params['format'] = 'json';

        $opts = self::$CURL_OPTS;
        $opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&', PHP_QUERY_RFC1738);
        $opts[CURLOPT_URL] = self::prepareRequestUrl();
        curl_setopt_array($ch, $opts);

        $result = curl_exec($ch);

        if (curl_errno($ch) !== 0) {
            return null;
        }

        return json_decode($result, true);
    }
}