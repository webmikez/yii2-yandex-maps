<?php
namespace katzz0\yandexmaps;

use yii\base\Component;
use yii\web\View;

/**
 * Class Api singleton
 *
 * Yandex Maps API component.
 */
class Api extends Component
{
    /**
     * @var string
     */
    public static $protocol = 'http';

    /**
     * @var string
     */
    public static $uri = 'api-maps.yandex.ru';

    /**
     * @var string
     */
    public static $version = '2.1';

    /**
     * @var string
     */
    public static $language;

    /**
     * @var array
     */
    public static $packages = ['package.full'];

    /**
     * @var Map Current Map
     */
    private static $currentMap;

    /**
     * Register script tag with maps api script
     * @see https://tech.yandex.ru/maps/doc/jsapi/2.1/dg/concepts/load-docpage/
     * @param Map $map
     */
    public static function registerApiFile(Map $map)
    {
        self::$currentMap = $map;

        self::$language = self::$language ?: (\Yii::$app->language ?: 'en-US');

        if ('https' !== self::$protocol) {
            self::$protocol = 'http';
        }

        if (is_array(self::$packages)) {
            self::$packages = implode(',', self::$packages);
        }

        $url = self::$protocol .
            '://' . self::$uri . '/' .
            self::$version
            . '/?lang=' . self::$language
            . '&load=' . self::$packages;

        \Yii::$app->view->registerJsFile($url, ['position' => View::POS_END], self::$uri);
    }

    /**
     * @return Map
     */
    public static function getCurrentMap()
    {
        return self::$currentMap;
    }
}