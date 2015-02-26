<?php
namespace katzz0\yandexmaps;

use yii\base\Component;

/**
 * Class Point
 * A two-point coordinates
 *
 * @property array $coordinates
 * @property float $x
 * @property float $y
 *
 */
class Point extends Component
{
    /**
     * @var float
     */
    private $x;

    /**
     * @var float
     */
    private $y;

    /**
     * Constructor
     * @param float $x
     * @param float $y
     */
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * Returns coordinates
     * @return array
     */
    public function getCoordinates()
    {
        return [$this->x, $this->y];
    }

    /**
     * Returns x component
     * @return float
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Returns y component
     * @return float
     */
    public function getY()
    {
        return $this->y;
    }
}