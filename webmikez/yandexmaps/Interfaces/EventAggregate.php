<?php
namespace webmikez\yandexmaps\Interfaces;

/**
 * interface EventAggregate
 */
interface EventAggregate
{
    /**
     * @return array
     */
    public function getEvents();
}