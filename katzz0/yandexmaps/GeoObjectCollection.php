<?php
namespace katzz0\yandexmaps;

use katzz0\yandexmaps\Interfaces;
use yii\helpers\Json;

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
    private $objects = [];

    /**
     * @return array
     */
    public function getObjects()
    {
        return $this->objects;
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
     * @param JavaScript $object
     */
    public function addObject(JavaScript $object)
    {
        $this->objects[] = $object;
    }

    /**
     * @inheritdoc
     */
    public function getCode()
    {
        $properties = Json::encode($this->getProperties());
        $options = Json::encode($this->getOptions());

        return "new ymaps.GeoObjectCollection($properties, $options)";
    }
}