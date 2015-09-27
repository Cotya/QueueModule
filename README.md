Cotya Queue Module for Magento2
===============================

An basic and bad written Module for Magento2 to support Queues



## Usage

add `Cotya\Queue\Model\QueueService $queueService,` to your constructor.

add an element to a queue by Name `$this->queueService->add('element 1', 'test-queue');`

fetch a single element from a queue by Name `$this->queueService->getSingleElement('test-queue');`

The value and queueName can be an arbitary string. Fetching an element removes it from queue. 