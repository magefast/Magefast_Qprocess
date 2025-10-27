# Magefast_Qprocess. <br>Magento module, Easy Add Task to Queue

## Sample module how can add Queue Message and processing it.


#### CLI command for retrieve list of all configured Queue Message:
<code>bin/magento queue:consumers:list</code>
<br><br>

#### CLI command for watch/listen Queue Messages:
<code>bin/magento queue:consumers:start -vvv qprocess.task</code>
<br><br>

### CLI command for add test Queue Message:
<code>bin/magento qprocess:test</code>
<br><br>

#### Service for Publish (add) Queue Message 
`\Magefast\Qprocess\Service\Add::execute`
<br><br>

#### Method where processed Queue Message, here can(need) add custom logic for processing - add Event, Service etc.
`\Magefast\Qprocess\Model\Task::processMessage`
<br><br>

## Sample: How To add Task to Queue with this Module Magefast_Qprocess

1) For example in Observer Class for event `catalog_product_save_after` need add Task for Sync/Send SMS <br>or Call to External services. 
   <br>Bellow sample of Observer Class

<pre>
namespace Strekoza\Sample\Observer;

use Magefast\Qprocess\Service\Add;
use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Serialize\Serializer\Json;

class ProductUpdateObserver implements ObserverInterface
{
    private Json $json;
    private Add $addMessageQueue;

    public function __construct(
        Json $json,
        Add  $addMessageQueue
    )
    {
        $this->json = $json;
        $this->addMessageQueue = $addMessageQueue;
    }

    public function execute(EventObserver $observer)
    {
        /** @var Product $product */
        $product = $observer->getEvent()->getProduct();

        /**
         * Add to QUEUE
         */
        $objectData = [];
        $objectData['sku'] = $product->getSku();

        $jsonData = [
            'type' => 'custom_task_product',
            'data' => $objectData
        ];

        $jsonSting = $this->json->serialize($jsonData);

        $this->addMessageQueue->execute('qprocess.task', $jsonSting);
    }
}

</pre>
<br>
2) Add solution for Processing of Task, that added before.
   It will added with event `qprocess_task`.
   Bellow peace of code for `etc/events.xml`

```xml
    <event name="qprocess_task">
        <observer name="sample_qprocess_task" instance="Strekoza\Sample\Observer\QprocessTask"/>
    </event>
```

   And Observer Class `QprocessTask`
   <pre>
namespace Strekoza\Sample\Observer;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Serialize\Serializer\Json;

class QprocessTask implements ObserverInterface
{
    private Json $json;

    public function __construct(
        Json $json
    )
    {
        $this->json = $json;
    }

    public function execute(Observer $observer)
    {
        $object = $observer->getEvent()->getObject();

        $data = $this->json->unserialize($object->getValue());

        if (!is_array($data)) {
            return;
        }

        if (!isset($data['type']) || !isset($data['data'])) {
            $object->setResult(false);
            return;
        }

        if ($data['type'] == 'custom_task_product') {
            try {

                $sku = $data['data']['sku'];
                //@todo YOUR LOGIC HERE with $sku of Product

                return;
            } catch (Exception $e) {
                return;
            }
        }
    }
}
</pre>
<br>
3) Its All. Take a look, if class/file `Observer\QprocessTask` is changed, need also regenerate code.



## Install With Composer

`composer require magefast/module-qprocess`

<br><br>
### Links
https://devdocs.magento.com/guides/v2.4/config-guide/mq/manage-message-queues.html
<br>
https://www.atwix.com/magento-2/getting-started-with-message-queues-in-magento/
<br>
https://store.magenest.com/blog/create-a-message-queue-in-magento-2/
<br>
https://webkul.com/blog/here-we-will-learn-how-to-configure-and-use-rabbitmq-in-magento-2-3/
<br>
https://blog.gaiterjones.com/magento-2-asynchronous-message-queue-management/
<br>
https://blogs.perficient.com/2021/03/09/rabbitmq-integration-with-magento-2-4/
<br>
https://amasty.com/knowledge-base/how-to-use-rabbitmq-in-magento-2-plugins.html
<br>
https://inviqa.com/blog/magento-2-tutorial-message-queues
