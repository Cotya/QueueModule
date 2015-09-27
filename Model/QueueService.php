<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\Queue\Model;

use Cotya\Queue\Model\Resource\AbstractQueue;
use Magento\Framework\ObjectManagerInterface;
use Psr\Log\LoggerInterface;

class QueueService
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var AbstractQueue
     */
    protected $resource;

    /**
     * @var LoggerInterface
     */
    protected $logger;


    public function __construct(
        LoggerInterface $logger,
        AbstractQueue $resource,
        ObjectManagerInterface $objectManager
    ) {
        $this->logger = $logger;
        $this->resource = $resource;
    }

    protected function log($msg, $queueName)
    {
        $this->logger->info('Queue "' . $queueName . '":'.$msg);
        //Mage::log( $msg, null, self::LOG_BASE_PATH.'_'.$this->queueName.'.log');
    }

    public function add($element, $queueName)
    {
        $element = (string) $element;
        $this->log('add element: '.$element, $queueName);
        $this->resource->add($element, $queueName);
    }
    

    public function getAllElements($queueName)
    {
        $this->log('get all elements', $queueName);
        return $this->resource->getAllReservedElements($queueName);
    }

    public function getSingleElement($queueName)
    {
        $this->log('get single element', $queueName);
        return $this->resource->getSingleReservedElement($queueName);
    }
}
