<?php
namespace katzz0\yandexmaps;

use yii\base\Component;

/**
 * Class JavaScript
 *
 * @property string $code
 */
class JavaScript extends Component
{
    /**
     * @var string
     */
    private $code;

    /**
     * @param string $code
     */
    public function __construct($code = '')
    {
        $this->setCode($code);
    }

    /**
     * Returns the JS code
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = (string) $code;
    }

    /**
     * Returns the JS variable name for this class
     * @return string
     */
    public function getVarName()
    {
        return lcfirst(substr(get_called_class(), strrpos(get_called_class(), '\\') + 1));
    }

    /**
     * Returns the JS code
     * @return string
     */
    function __toString()
    {
        try {
            $code = $this->getCode();
            return $code ?: '';
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            return '';
        }
    }
}