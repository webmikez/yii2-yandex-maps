<?php
namespace katzz0\yandexmaps;

use yii\base\InvalidParamException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;

/**
 * Class Canvas
 *
 * @property Api $api
 * @property Map $map
 */
class Canvas extends Widget
{
    /**
     * @var Map Current Map object
     */
    public $map;

    /**
     * @var string
     */
    public $tagName = 'div';

    /**
     * @var array
     */
    public $htmlOptions = [
        'class' => 'yandex-map',
        'style' => 'height: 100%; width: 100%;',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!($this->map instanceof Map)) {
            throw new InvalidParamException('Param map is not set');
        }
    }

    /**
     * Run widget
     */
    public function run()
    {
        $this->registerScripts();

        $this->htmlOptions['id'] = $this->map->id;
        return Html::tag($this->tagName, '', $this->htmlOptions);
    }

    /**
     * Register scripts for map control
     */
    private function registerScripts()
    {
        Api::registerApiFile($this->map);

        $js = "\nymaps.ready(function() {\n" .(string) $this->map ."\n});";
        \Yii::$app->view->registerJs($js, View::POS_READY);
    }
}