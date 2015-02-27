<?php
namespace katzz0\yandexmaps;

use yii\base\Component;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Class Geometry
 *
 * Array of the points
 */
class Geometry extends Component
{
    const TYPE_POINT = 'Point';
    const TYPE_LINE = 'LineString';
    const TYPE_POLYGON = 'Polygon';

    /**
     * @var Point[] Points
     */
    private $points = [];

    /**
     * @var string
     */
    private $type;

    /**
     * Construct
     * @param string $type
     * @param Point[] $points
     */
    public function __construct($type, array $points)
    {
        $this->type = $type;

        foreach ($points as $point) {
            if ($point === null) {
                continue;
            }

            $this->addPoint($point);
        }
    }

    /**
     * @return Point[]
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Point $point
     */
    public function addPoint(Point $point)
    {
        $this->points[] = $point;
    }

    /**
     * Returns json
     * @return string
     */
    public function getJson()
    {
        $data = [
            'type' => $this->type,
            'coordinates' => []
        ];

        if (!count($this->points) && $map = Api::getCurrentMap()) {
            $data['coordinates'] = new JsExpression($map->getId().'.getCenter()');
        } elseif (count($this->points) === 1) {
            $data['coordinates'] = $this->points[0]->getCoordinates();
        } else {
            foreach ($this->points as $point) {
                $data['coordinates'][] = $point->getCoordinates();
            }
        }

        return Json::encode($data);
    }
}