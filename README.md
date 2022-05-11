# Magefast_Qprocess

## Sample module how can add Queue Message and processing it.

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
\Magefast\Qprocess\Model\Task::processMessage
