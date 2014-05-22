## DatagridHelperBundle - Remove Columns

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

5. In order to remove a column you need to know what this columns is called in the datagrid.yml
I've used the contacts grid as an example, the datagrid.yml can be found in:
/orocrm/vendor/oro/crm/src/OroCRM/Bundle/ContactBundle/Resources/config/datagrid.yml

In this example I've used the 'updatedAt' column. Just pass the GridConfiguration as the first parameter and the 
fieldname of the column as the second parameter.

```bash
    public function buildBefore(BuildBefore $event) {

        $gridConfig = $event->getConfig();
        $this->datagridHelper->removeColumn($gridConfig, 'updatedAt');
    }
```

5.1 In order to remove multiple columns you can use

```bash
    public function buildBefore(BuildBefore $event) {

        $gridConfig = $event->getConfig();
        $this->datagridHelper->removeColumns($gridConfig, array('updatedAt', 'primaryPhone'));
    }
```

You can use the removeColumns function and pass an array with field names as the second parameter

Good luck!