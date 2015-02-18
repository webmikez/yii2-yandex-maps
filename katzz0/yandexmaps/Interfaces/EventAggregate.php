<?php
namespace katzz0\yandexmaps\Interfaces;

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