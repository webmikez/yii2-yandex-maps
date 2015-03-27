<?php
namespace katzz0\yandexmaps;

use yii\helpers\Json;

/**
 * Class Geocoder
 *
 * Geocoder wrapper
 */
class JsGeoCoderWrapper extends JavaScript
{
    /**
     * @var int Counter
     */
    static private $counter = 0;

    /**
     * @var string Name of the place
     */
    private $place;

    /**
     * @inheritdoc
     */
    public function __construct($place, $code)
    {
        $this->place = $place;

        $pointVarName = 'point' . self::$counter++;
        $js = "var $pointVarName = res.geoObjects.get(0).geometry.getCoordinates();\n";
        $js .= str_replace(Json::encode($this->place), $pointVarName, $code);

        $encodedPlace = str_replace('"', '\\"', $this->place);
        $code = "ymaps.geocode(\"{$encodedPlace}\", {result : 1}).then(function (res) {\n$js\n});";

        parent::__construct($code);
    }
}