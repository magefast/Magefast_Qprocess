# Magefast_Qprocess. Magento module, Easy Add Task to Queue

## Sample module how can add Queue Message and processing it.


SSH command for retrieve list of all configured Queue Message:
<br>
<code>bin/magento queue:consumers:list</code>

SSH command for watch/listen Queue Messages:
<br>
<code>bin/magento queue:consumers:start -vvv qprocess.task</code>

SSH command for add test Queue Message:
<br>
<code>bin/magento qprocess:test</code>

<br>
<br>

#### Service for Publish (add) Queue Message 
`\Magefast\Qprocess\Service\Add::execute`


#### Method where processed Queue Message, here can(need) add custom logic for processing - add Event, Service etc.
`\Magefast\Qprocess\Model\Task::processMessage`



## Sample: How To add Task to Queue with this Module Magefast_Qprocess

1) For example in Observer Class for event `catalog_product_save_after` need add Task for Sync/Send SMS or Call to Externall services. Bellow sample of Observer Class

<pre>
namespace Strekoza\HTMLcacheR2\Observer;

use Magefast\Qprocess\Service\Add;
use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Strekoza\HTMLcacheR2\Service\Settings;

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
            'type' => Settings::QUEUE_TYPE_NAME_PRODUCT,
            'data' => $objectData
        ];

        $jsonSting = $this->json->serialize($jsonData);

        $this->addMessageQueue->execute('qprocess.task', $jsonSting);
    }
}

</pre>

2) Add PHP Class for Processing of Task, that added before.
   It will added with event `qprocess_task`.
   Bellow peace of code for `etc/events.xml`
   


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
