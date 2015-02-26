<?php
namespace katzz0\yandexmaps\Interfaces;

use katzz0\yandexmaps\objects\Point;

/**
 * interface GeoObject
 */
interface GeoObject
{
    /**
     * @return array
     */
    public function getOptions();

    /**
     * @param array $options
     */
    public function setOptions(array $options);

    /**
     * @return array
     */
    public function getGeometry();

    /**
     * @param Point|array|string $geometry
     */
    public function setGeometry($geometry);

    /**
     * @return array
     */
    public function getProperties();

    /**
     * @param array $properties
     */
    public function setProperties(array $properties);
}