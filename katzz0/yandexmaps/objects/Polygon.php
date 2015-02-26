<?php
namespace katzz0\yandexmaps\objects;

use katzz0\yandexmaps\Geometry;
use katzz0\yandexmaps\GeoObject;
use yii\helpers\Json;

/**
 * Class Polyline
 */
class Polygon extends GeoObject
{
    /**
     * @param array $points
     * @param array $properties
     * @param array $options
     */
    public function __construct(array $points, array $properties = [], array $options = [])
    {
        $geometry = new Geometry(Geometry::TYPE_POLYGON, $points);
        parent::__construct($geometry, $properties, $options);
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

        $content = '';

        if (is_array($geometry)) {
            foreach ($geometry as $_points) {
                $point = [$_points->latitude, $_points->longitude];
                $points[] = $point;
            }
            if (isset($points)) {
                $content = [$points];
            }
        } else {
            $content = $geometry;
        }

        return $content;
    }

    /**
     * @inheritdoc
     */
    public function getCode()
    {
        $geometry = Json::encode($this->getGeometry());
        $properties = Json::encode($this->getProperties());
        $options = Json::encode($this->getOptions());

        return "new ymaps.Polygon($geometry, $properties, $options)";
    }

}