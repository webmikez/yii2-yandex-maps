<?php
namespace webmikez\yandexmaps\Interfaces;

use webmikez\yandexmaps\JavaScript;

/**
 * interface GeoObject
 */
interface GeoObjectCollection
{
    /**
     * @return array
     */
    public function getObjects();

    /**
     * @param array $objects
     */
    public function setObjects(array $objects = []);

    /**
     * @param JavaScript $object
     */
    public function addObject(JavaScript $object);
}