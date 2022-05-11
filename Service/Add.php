<?php

namespace Magefast\Qprocess\Service;

use Magento\Framework\MessageQueue\PublisherInterface;

class Add
{
    const TOPIC_NAME = 'qprocess.task';

    /**
     * @var PublisherInterface
     */
    private $publisher;

    /**
     * @param PublisherInterface $publisher
     */
    public function __construct(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @param string $value
     */
    public function execute(string $value)
    {
        $this->publisher->publish(self::TOPIC_NAME, $value);
    }
}