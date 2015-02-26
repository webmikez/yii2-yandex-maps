<?php
namespace katzz0\yandexmaps;

/**
 * Class Geocoder
 *
 * Geocoder wrapper
 */
class GeoCoder extends JavaScript
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
        $js .= preg_replace("/('|\"){$this->place}('|\")/", $pointVarName, $code);

        $code = "ymaps.geocode(\"{$this->place}\", {result : 1}).then(function (res) {\n$js\n});";

        parent::__construct($code);
    }
}