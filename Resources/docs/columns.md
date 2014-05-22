Removing Columns
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

- In order to remove a column you need to know what this columns is called in the datagrid.yml
I've used the contacts grid as an example, the datagrid.yml can be found in:
/orocrm/vendor/oro/crm/src/OroCRM/Bundle/ContactBundle/Resources/config/datagrid.yml

In this example I've used the 'updatedAt' column. Just pass the GridConfiguration as the first parameter and the 
fieldname of the column as the second parameter.

```
    public function buildBefore(BuildBefore $event) {

        $gridConfig = $event->getConfig();
        $this->datagridHelper->removeColumn($gridConfig, 'updatedAt');
    }
```

- In order to remove multiple columns you can use

```
    public function buildBefore(BuildBefore $event) {

        $gridConfig = $event->getConfig();
        $this->datagridHelper->removeColumns($gridConfig, array('updatedAt', 'primaryPhone'));
    }
```

You can use the removeColumns function and pass an array with field names as the second parameter

Good luck!