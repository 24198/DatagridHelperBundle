## DatagridHelperBundle - Enable / Disable Filters

1. Create an event listener for a Datagrid. 

2. Add the datagrid helper as an argument to this event listener in the services.yml

```bash
        arguments: 
            - @tfone_datagrid.datagrid_helper
```

3. Add the class to your event listener class by adding

```bash
    use Tfone\Bundle\DatagridHelperBundle\Datagrid\Helper;
```

4. Add a protected field & construct method to you event listener

```bash
    /** @var Helper $datagridHelper */
    protected $datagridHelper;

    public function __construct(DatagridHelper $datagridHelper) {
        $this->datagridHelper = $datagridHelper;
    }
```

5. In order to enable or disable a filter you need to know what the column name is in the datagrid.yml
I've used the contacts grid as an example, the datagrid.yml can be found in:
/orocrm/vendor/oro/crm/src/OroCRM/Bundle/ContactBundle/Resources/config/datagrid.yml

In this example I've used the 'firstName' column. Just pass the GridConfiguration as the first parameter, the 
fieldname of the filter as the second parameter and true / false as the third parameter for enabling or disabling
the filter. By default the third parameter is true.

```bash
    public function buildBefore(BuildBefore $event) {
    
        $gridConfig = $event->getConfig();
        $this->datagridHelper->enableFilters($gridConfig, 'firstName', false);
    }
```

5.1 In order to enable or disable multiple filters you can use

```bash
    public function buildBefore(BuildBefore $event) {
    
        $gridConfig = $event->getConfig();
        $this->datagridHelper->enableFilters($gridConfig, array('updatedAt' => true, 'firstName' => false));

    }
```

You can use the enableFilters function and pass an array with fieldname => enable as key value pairs.

Good luck!