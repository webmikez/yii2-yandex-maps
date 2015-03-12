<?php
namespace katzz0\yandexmaps;

use yii\base\InvalidParamException;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class StaticCanvas Use Static API for displaying the map
 */
class StaticCanvas extends Widget
{
    const LAYER_MAP = 'map';
    const LAYER_PEOPLE_MAP = 'pmap';
    const LAYER_SATELLITE = 'sat';
    const LAYER_SKL = 'skl';
    const LAYER_PEOPLE_SKL = 'pskl';
    const LAYER_TRAFFIC = 'trf';

    /**
     * @var string Layers of the map. The lowest layer should be listed first
     */
    public $layers = self::LAYER_MAP;

    /**
     * @var Point|array|string Center of the map. If string specified, the used geocoder for detect coordinates
     */
    public $center;

    /**
     * @var int Scale of the map, range 0-17
     */
    public $scale;

    /**
     * @var array Size of the requested image
     */
    public $size;

    /**
     * @var array List of the points, each item must be of the 3 elemet array [lat, long, type]
     */
    public $points;

    /**
     * @var array Html options for the widget
     */
    public $options;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $src = Api::$protocol.'://'.
            Api::$staticUri.'/'.
            Api::$staticVersion.'/?';

        $params = $this->makeParams();
        if (!$params) {
            return null;
        }

        $this->options = $this->options ?: [];
        return Html::img($src.$params, $this->options);
    }

    /**
     * Build query params
     * @return string
     */
    private function makeParams()
    {
        $params = [];

        $layers = (array) $this->layers;
        $params['l'] = implode(',', $layers);

        if (!$this->center) {
            throw new InvalidParamException('center must be specified');
        }

        if (is_string($this->center)) {
            if (!($this->center = GeoCoder::findFirst($this->center))) {
                return null;
            }
        } elseif (!$this->center instanceof Point && (!is_array($this->center) || count($this->center) !== 2)) {
            throw new InvalidParamException('Invalid specified geoPoint param');
        }

        $this->center = is_array($this->center) ? new Point($this->center[0], $this->center[1]) : $this->center;
        $params['ll'] = $this->center->getX().','.$this->center->getY();

        if ($this->scale) {
            $params['z'] = $this->scale < 0 ? 0 : ($this->scale > 17 ? 17 : $this->scale);
        }

        if ($this->size) {
            if (!is_array($this->size) || count($this->size) !== 2) {
                throw new InvalidParamException('Invalid specified size param, it must be array with length 2');
            }

            $params['size'] = implode(',', $this->size);
        }

        if (!empty($this->points)) {
            $params['pt'] = implode('~', array_map(function ($v) {
                return ($v[0] ?: $this->center->getX()).','.($v[1] ?: $this->center->getY()).','.$v[2];
            }, $this->points));
        }

        return http_build_query($params);
    }
}