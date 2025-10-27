<?php
/**
 * @author magefast@gmail.com www.magefast.com
 */

namespace Magefast\Qprocess\Service;

use Magento\Framework\MessageQueue\PublisherInterface;

class Add
{
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
    public function execute(string $topicName, string $value)
    {
        $this->publisher->publish($topicName, $value);
    }
}