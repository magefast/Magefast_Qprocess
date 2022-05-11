# Magefast_Qprocess

## Sample module how can add Queue Message and processing it.


SSH command for retrieve list of all configured Queue Message:
<br>
<code>bin/magento queue:consumers:list</code>

SSH command for add test Queue Message:
<br>
<code>bin/magento qprocess:test</code>

SSH command for watch/listen Queue Messages:
<br>
<code>bin/magento queue:consumers:start -vvv qprocess.task</code>
<br>
<br>
#### Service for Publish (add) Queue Message 
`\Magefast\Qprocess\Service\Add::execute`


#### Method where processed Queue Message, here can(need) add custom logic for processing - add Event, Service etc.
`\Magefast\Qprocess\Model\Task::processMessage`

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
