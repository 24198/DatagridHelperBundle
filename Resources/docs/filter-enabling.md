Enable / Disable Filters
=====================

- Create an event listener for a Datagrid. 

- Add the datagrid helper as an argument to this event listener in the services.yml

```yaml
parameters:        
    tfone_contact.datagrid_contact_listener.class:              Tfone\Bundle\ContactBundle\EventListener\Datagrid\ContactListener
  
        
services:    
    # event listener    
    tfone_contact.datagrid_contact_listener:
        class: %tfone_contact.datagrid_contact_listener.class%
        arguments: 
            - @tfone_datagrid.datagrid_helper
        tags:
            - { name: kernel.event_listener, event: oro_datagrid.datagrid.build.before.contacts-grid, method: buildBefore }
```

- Add the class to your event listener class by adding

```
    use Tfone\Bundle\DatagridHelperBundle\Datagrid\Helper;
```

- Add a protected field & construct method to you event listener

```
    /** @var Helper $datagridHelper */
    protected $datagridHelper;

    public function __construct(DatagridHelper $datagridHelper) {
        $this->datagridHelper = $datagridHelper;
    }
```

- In order to enable or disable a filter you need to know what the column name is in the datagrid.yml
I've used the contacts grid as an example, the datagrid.yml can be found in:
/orocrm/vendor/oro/crm/src/OroCRM/Bundle/ContactBundle/Resources/config/datagrid.yml

In this example I've used the 'firstName' column. Just pass the GridConfiguration as the first parameter, the 
fieldname of the filter as the second parameter and true / false as the third parameter for enabling or disabling
the filter. By default the third parameter is true.

```
    public function buildBefore(BuildBefore $event) {
    
        $gridConfig = $event->getConfig();
        $this->datagridHelper->enableFilters($gridConfig, 'firstName', false);
    }
```

- In order to enable or disable multiple filters you can use

```
    public function buildBefore(BuildBefore $event) {
    
        $gridConfig = $event->getConfig();
        $this->datagridHelper->enableFilters($gridConfig, array('updatedAt' => true, 'firstName' => false));

    }
```

You can use the enableFilters function and pass an array with fieldname => enable as key value pairs.

Good luck!