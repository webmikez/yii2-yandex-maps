<?php
namespace katzz0\yandexmaps\objects;

use katzz0\yandexmaps\Geometry;
use katzz0\yandexmaps\GeoObject;
use katzz0\yandexmaps\Point;
use yii\helpers\Json;

/**
 * Class Placemark
 */
class Placemark extends GeoObject
{
    /**
     * @param Point|string $point Point or name of the place. If null, then placemark will be at the map center
     * @param array $properties
     * @param array $options
     */
    public function __construct(Point $point = null, array $properties = [], array $options = [])
    {
        $geometry = new Geometry(Geometry::TYPE_POINT, [$point]);
        parent::__construct($geometry, $properties, $options);
    }

    /**
     * @inheritdoc
     */
    public function getCode()
    {
        $geometry = $this->getGeometry()->getJson();
        $properties = Json::encode($this->getProperties(), 0);
        $options = Json::encode($this->getOptions());

        return "new ymaps.Placemark($geometry, $properties, $options)";
    }
}