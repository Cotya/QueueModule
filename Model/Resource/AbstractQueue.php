<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\Queue\Model\Resource;

use Cotya\Queue\Model\Queue;

abstract class AbstractQueue
{
    protected $queueName;

    public function __construct()
    {
        
    }

    abstract public function add($element, $queueName);

    // abstract public function reserve();

    abstract public function getAllReservedElements($queueName);

    abstract public function getSingleReservedElement($queueName);
}
