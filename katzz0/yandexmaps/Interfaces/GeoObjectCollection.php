<?php
namespace katzz0\yandexmaps\Interfaces;

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
     * @param mixed $object
     */
    public function addObject($object);
}