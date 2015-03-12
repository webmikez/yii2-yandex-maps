<?php
namespace katzz0\yandexmaps;

use yii\base\Exception;
use yii\helpers\Json;
use katzz0\yandexmaps\Interfaces\GeoObjectCollection;
use katzz0\yandexmaps\Interfaces\EventAggregate;

/**
 * Class Map
 *
 * @property string $id
 * @property array $objects
 * @property array $controls
 */
class Map extends JavaScript implements GeoObjectCollection, EventAggregate
{
    const CONTROL_MAP_TOOLS = 'mapTools';
    const CONTROL_MINI_MAP = 'miniMap';
    const CONTROL_SCALE_LINE = 'scaleLine';
    const CONTROL_SEARCH = 'searchControl';
    const CONTROL_TRAFFIC = 'trafficControl';
    const CONTROL_TYPE_SELECTOR = 'typeSelector';
    const CONTROL_ZOOM = 'zoomControl';

    const BEHAVIOR_DEFAULT = 'default';
    const BEHAVIOR_DRAG = 'drag';
    const BEHAVIOR_SCROLL_ZOOM = 'scrollZoom';
    const BEHAVIOR_CLICK_ZOOM = 'dblClickZoom';
    const BEHAVIOR_MULTI_TOUCH = 'multiTouch';
    const BEHAVIOR_RIGHT_MAGNIFIER = 'rightMouseButtonMagnifier';
    const BEHAVIOR_LEFT_MAGNIFIER = 'leftMouseButtonMagnifier';
    const BEHAVIOR_RULER = 'ruler';
    const BEHAVIOR_ROUTE_EDITOR = 'routeEditor';

    /**
     * @var int Widgets counter
     */
    public static $counter = 0;

    /**
     * @var array Map state options
     */
    public $state = [];

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var string
     */
    private $id;

    /**
     * @var JavaScript[] Objects in the map
     */
    private $objects = [];

    /**
     * @var JavaScript[] Control item in the map
     */
    private $controls = [];

    /**
     * @var array
     */
    private $events = [];

    /**
     * @param string $id
     * @param array $state
     * @param array $options
     */
    public function __construct($id = null, array $state = [], array $options = [])
    {
        $id = $id ?: self::$counter++;

        $this->setId($id);
        $this->state = $state;
        if (isset($options['controls'])) {
            $this->setControls($options['controls']);
            unset($options['controls']);
        }
        if (isset($options['events'])) {
            $this->setEvents($options['events']);
            unset($options['events']);
        }
        if (isset($options['objects'])) {
            $this->setObjects($options['objects']);
            unset($options['objects']);
        }
        $this->options = $options;
    }

    /**
     * Clone object.
     */
    function __clone()
    {
        $this->id = null;
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
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * @param array $objects
     */
    public function setObjects(array $objects = [])
    {
        $this->objects = [];
        foreach ($objects as $object) {
            $this->addObject($object);
        }
    }

    /**
     * @param JavaScript $object
     * @return Map
     */
    public function addObject(JavaScript $object)
    {
        $this->objects[] = $object;
        return $this;
    }

    /**
     * @return array
     */
    public function getControls()
    {
        return $this->controls;
    }

    /**
     * @param array $controls
     */
    public function setControls(array $controls)
    {
        $this->controls = [];
        foreach ($controls as $control) {
            $this->addControl($control);
        }
    }

    /**
     * The control.
     * ```php
     * $map->addControl(['zoomControl', [
     *    'left' => '5px',
     *    'top' => '5px',
     * ]]);
     * ```
     * @param mixed $control
     * @return $this
     * @throws Exception
     * @todo Add control interface.
     */
    public function addControl($control)
    {
        if (is_string($control)) {
            $control = array($control);
        } elseif (is_array($control) && (!isset($control[0]) || !is_string($control[0]))) {
            throw new Exception('Invalid control.');
        }
        $this->controls[$control[0]] = $control;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCode()
    {
        $state = Json::encode($this->state);
        $options = Json::encode($this->options);

        $js = ["{$this->getId()} = new ymaps.Map('{$this->id}', $state, $options)"];

        if (count($this->objects) > 0) {
            $js[] = $this->makeObjectsScript();
        }
        if (count($this->controls) > 0) {
            $js[] = $this->makeControlsScript();
        }

        $js = implode(";\n", $js);
        if (isset($this->state['center']) && is_string($this->state['center'])) {
            $js = (string) new JsGeoCoderWrapper($this->state['center'], $js);
        }

        return $js;
    }

    /**
     * Generates JS script lines for map objects
     * @return string
     */
    private function makeObjectsScript()
    {
        $js = [];
        $geoObjects = [];

        $varCounter = 0;
        foreach ($this->objects as $i => $object) {
            if ($object instanceof GeoObject) {
                $var = $object->getVarName() . $varCounter++;

                $js[] = 'var ' . $var . ' = ' . (string) $object;
                if ($events = $this->makeBindEventsScript($var, $object)) {
                    $js[] = $events;
                }

                $geoObjects[] = ".add($var)";
            } else {
                $js[] = (string) $object;
            }
        }

        if (!empty($geoObjects)) {
            $js[] = "{$this->getId()}.geoObjects" . implode($geoObjects) . ';';
        }

        return implode(";\n\t", $js);
    }

    /**
     * Generates JS script lines for map controls
     * @return string[]
     */
    private function makeControlsScript()
    {
        $controls[] = "{$this->getId()}.controls";

        foreach ($this->controls as $control) {
            if (count($control) > 1) {
                $config = Json::encode($control[1]);
                $controls[] = ".add($control[0], $config)";
            } else {
                $controls[] = ".add($control[0])";
            }
        }

        return implode('', $controls);
    }

    /**
     * Bind event to the item
     */
    private function makeBindEventsScript($var, GeoObject $object)
    {
        if (!count($object->getEvents())) {
            return null;
        }

        $events = ["$var.events"];

        foreach ($object->getEvents() as $event => $handle) {
            $event = Json::encode($event);
            if (is_string($handle) && strpos($handle, 'js:') === 0) {
                $handle = substr($handle, 3);
            } else {
                $handle = Json::encode($handle);
            }
            $events[] = ".add($event, $handle)";
        }

        return implode($events);
    }
}