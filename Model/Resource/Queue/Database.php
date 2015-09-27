<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\Queue\Model\Resource\Queue;

use Cotya\Queue\Model\Resource\AbstractQueue;

class Database extends AbstractQueue
{
    /**
     * @var \Magento\Framework\Model\Resource\Db\Context
     */
    protected $dbContext;
    
    public function __construct(
        \Magento\Framework\Model\Resource\Db\Context $context
    ) {
        parent::__construct();
        $this->dbContext = $context;
    }

    protected function getConnection()
    {
        return $this->dbContext->getResources()->getConnection('default');
    }

    protected function getTableName()
    {
        return $this->dbContext->getResources()->getTableName('cotya_queue');
    }
    
    public function add($element, $queueName)
    {
        $connection = $this->getConnection();
        $tableName  = $this->getTableName();
        $connection->query(
            "Insert into $tableName (`type`, `value`) values (?,?)",
            array(
                $queueName,
                $element
            )
        );
    }

    public function getAllReservedElements($queueName)
    {
        $connection = $this->getConnection();
        $tableName  = $this->getTableName();

        $queryResult = $connection->fetchAll(
            "Select * From $tableName where `type` = ?",
            array($queueName)
        );

        $ids    = array();
        $values = array();
        foreach ($queryResult as $element) {
            $ids[] = $element['id'];
            $values[] = $element['value'];
        }
        $idString = implode("','", $ids);
        $connection->query(
            "Delete From $tableName Where `id` IN ('$idString')"
        );

        return $values;
    }

    public function getSingleReservedElement($queueName)
    {
        $connection = $this->getConnection();
        $tableName  = $this->getTableName();

        $queryResult = $connection->fetchAll(
            "Select * From $tableName where `type` = ? Limit 1",
            array($queueName)
        );

        $ids    = array();
        $values = array();
        foreach ($queryResult as $element) {
            $ids[] = $element['id'];
            $values[] = $element['value'];
        }
        $idString = implode("','", $ids);
        $connection->query(
            "Delete From $tableName Where `id` IN ('$idString')"
        );

        return array_shift($values);
    }
}
