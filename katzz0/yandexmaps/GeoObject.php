<?php
namespace katzz0\yandexmaps;

use katzz0\yandexmaps\Interfaces;
use yii\base\Exception;

/**
 * Class GeoObject
 *
 * @property array $feature
 * @property array $options
 * @property array $properties
 * @property array $geometry
 */
class GeoObject extends JavaScript implements Interfaces\GeoObject, Interfaces\EventAggregate
{
    /**
     * @var Geometry Position of the object
     */
    private $geometry;

    /**
     * @var array
     */
    private $properties = [];

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var array
     */
    private $events = [];

    /**
     * Constructor
     * @param Geometry $geometry
     * @param array
     * @param array $options$properties
     */
    public function __construct(Geometry $geometry, array $properties = [], array $options = [])
    {
        if (isset($options['events'])) {
            $this->setEvents($options['events']);
            unset($options['events']);
        }

        $this->setGeometry($geometry);
        $this->setProperties($properties);
        $this->setOptions($options);
    }

    /**
     * @param string $code
     * @throws Exception
     */
    final public function setCode($code)
    {
        throw new Exception('Cannot change code directly.');
    }

    /**
     * @param array $events
     */
    public function setEvents(array $events)
    {
        $this->events = $events;
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return Geometry
     */
    public function getGeometry()
    {
        return $this->geometry;
    }

    /**
     * @param Point|string $geometry
     */
    public function setGeometry($geometry)
    {
        $this->geometry = $geometry;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
    }
}