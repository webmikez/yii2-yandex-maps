<?php
namespace katzz0\yandexmaps\objects;

use katzz0\yandexmaps\GeoObject;

/**
 * Class Placemark
 */
class Placemark extends GeoObject
{
    /**
     * @param array $geometry
     * @param array $properties
     * @param array $options
     */
    public function __construct(array $geometry, array $properties = [], array $options = [])
    {
        $feature = [
            'geometry' => [
                'type' => "Point",
                'coordinates' => $geometry,
            ],
            'properties' => $properties,
        ];
        parent::__construct($feature, $options);
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
}