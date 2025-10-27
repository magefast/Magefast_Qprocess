<?php
/**
 * @author magefast@gmail.com www.magefast.com
 */

namespace Magefast\Qprocess\Model;

use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;

class Task
{
    /**
     * \Magento\Framework\Event\ManagerInterface $eventManager,
     */
    protected $eventManager;

    public function __construct(ManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    public function processMessage(string $value)
    {
        $result = null;

        $observerData = [
            'value' => $value,
            'result' => $result
        ];
        $object = new DataObject($observerData);

        $this->eventManager->dispatch('qprocess_task', ['object' => $object]);

        $result = $object->getResult();

        if ($result === false) {
            throw new LocalizedException(new Phrase('Problem with Task processing.' . $value));
        }
    }
}
