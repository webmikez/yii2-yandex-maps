<?php
namespace katzz0\yandexmaps\objects;

use katzz0\yandexmaps\Geometry;
use katzz0\yandexmaps\GeoObject;
use yii\helpers\Json;

/**
 * Class Polyline
 */
class Polyline extends GeoObject
{
    /**
     * @param array $points
     * @param array $properties
     * @param array $options
     */
    public function __construct(array $points, array $properties = [], array $options = [])
    {
        $geometry = new Geometry(Geometry::TYPE_LINE, $points);
        parent::__construct($geometry, $options);
    }

    /**
     * @return array
     */
    public function getGeometry()
    {
        $geometry = parent::getGeometry();
        if (isset($geometry['coordinates'])) {
            $geometry = $geometry['coordinates'];
        }
        return $geometry;
    }

    /**
     * @inheritdoc
     */
    public function getCode()
    {
        $geometry = Json::encode($this->getGeometry());
        $properties = Json::encode($this->getProperties());
        $options = Json::encode($this->getOptions());

        return "new ymaps.Polyline($geometry, $properties, $options)";
    }
}