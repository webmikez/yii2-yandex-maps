<?php
namespace katzz0\yandexmaps;

use yii\base\Exception;
use yii\base\Widget;
use yii\helpers\Html;
use yii\base\Event;
use yii\base\View;

/**
 * Class Canvas
 *
 * @property Api $api
 * @property Map $map
 */
class Canvas extends Widget
{
    const EVENT_AFTER_RENDER = 'afterRender';

    /**
     * @var string
     */
    public static $componentId = 'yandexMapsApi';

    /**
     * @var string
     */
    public $tagName = 'div';

    /**
     * @var array
     */
    public $htmlOptions = array(
        'class' => 'yandex-map',
        'style' => 'height: 100%; width: 100%;',
    );

    /**
     * @var Map Current Map object
     */
    private $_map;

    /**
     * @var bool Is already rendered map
     */
    private $isRendered = false;

    /**
     * @return Api
     */
    public function getApi()
    {
        return \Yii::$app->get(self::$componentId);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        Event::on(View::className(), View::EVENT_AFTER_RENDER, function ($event) {
            if (!$this->isRendered) {
                \Yii::$app->get('yandexMapsApi')->render();
                $this->isRendered = true;
            }
        });
    }

    /**
     * Returns the Map object
     * @return Map
     * @throws Exception
     */
    public function getMap()
    {
        if (null === $this->_map) {
            throw new Exception('Orphan map canvas.');
        }
        return $this->_map;
    }

    /**
     * @param Map $map
     */
    public function setMap(Map $map)
    {
        $this->_map = $map;
        $this->api->addObject($map, $map->id);
    }

    /**
     * Run widget.
     */
    public function run()
    {
        parent::run();
        $this->htmlOptions['id'] = $this->map->id;
        echo Html::tag($this->tagName, '', $this->htmlOptions);
    }
}