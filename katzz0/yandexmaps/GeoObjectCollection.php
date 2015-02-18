<?php
namespace katzz0\yandexmaps;

use katzz0\yandexmaps\Interfaces;

/**
 * Class GeoObjectsCollection
 *
 * Objects collection
 *
 * @property array $objects
 */
class GeoObjectCollection extends GeoObject implements Interfaces\GeoObjectCollection
{
    /**
     * @var array
     */
    private $_objects = [];

    /**
     * @return array
     */
    public function getObjects()
    {
        return $this->_objects;
    }

    /**
     * @param array $objects
     */
    public function setObjects(array $objects = [])
    {
        $this->_objects = array();
        foreach ($objects as $object) {
            $this->addObject($object);
        }
    }

    /**
     * @param Interfaces\GeoObject $object
     */
    public function addObject($object)
    {
        $this->_objects[] = $object;
    }
}