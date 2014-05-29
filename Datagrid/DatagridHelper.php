<?php

namespace Tfone\Bundle\DatagridHelperBundle\Datagrid;

use Oro\Bundle\DataGridBundle\Datagrid\Common\DatagridConfiguration;


class Helper {
    
    const DATAGRID_COLUMNS_NAME  = '[columns][%s]';
    
    const DATAGRID_FILTERS_NAME  = '[filters][columns][%s]';
        
    const DATAGRID_SORTERS_NAME  = '[sorters][columns][%s]';
    
    /**
     * Remove single column from datagrid
     * 
     * @param DatagridConfiguration $config
     * @param string $fieldName
     */
    public function removeColumn(DatagridConfiguration $config, $fieldName) {
        if(!$fieldName || !$config) {
            throw new \LogicException(sprintf('Cannot remove column, grid config or fieldname is not specified.'));
        }
        
        $config->offsetUnsetByPath(sprintf(self::DATAGRID_COLUMNS_NAME, $fieldName));
        $config->offsetUnsetByPath(sprintf(self::DATAGRID_FILTERS_NAME, $fieldName));
        $config->offsetUnsetByPath(sprintf(self::DATAGRID_SORTERS_NAME, $fieldName));
    }
    
    /**
     * Remove multiple columns from datagrid
     * 
     * @param DatagridConfiguration $config
     * @param array $fields
     */
    public function removeColumns(DatagridConfiguration $config, $fields) {
        if(!is_array($fields)) {
            throw new \LogicException(sprintf('Cannot remove colums, parameter 2 is not an array.'));
        }
        
        foreach($fields as $fieldName) {
            $this->removeColumn($config, $fieldName);
        }
    }

    /**
     * Remove single filter from datagrid
     * 
     * @param DatagridConfiguration $config
     * @param string $fieldName
     */    
    public function removeFilter(DatagridConfiguration $config, $fieldName) {
        if(!$fieldName || !$config) {
            throw new \LogicException(sprintf('Cannot remove column, grid config or fieldname is not specified.'));
        }
        $config->offsetUnsetByPath(sprintf(self::DATAGRID_FILTERS_NAME, $fieldName));
    }

    /**
     * Remove multiple filters from datagrid
     * 
     * @param DatagridConfiguration $config
     * @param array $fields
     */    
    public function removeFilters(DatagridConfiguration $config, $fields) {
        if(!is_array($fields)) {
            throw new \LogicException(sprintf('Cannot remove colums, parameter 2 is not an array.'));
        }
        
        foreach($fields as $fieldName) {
            $this->removeFilter($config, $fieldName);
        }        
    }

    /**
     * Remove single sorter from datagrid
     * 
     * @param DatagridConfiguration $config
     * @param string $fieldName
     */    
    public function removeSorter(DatagridConfiguration $config, $fieldName) {
        if(!$fieldName || !$config) {
            throw new \LogicException(sprintf('Cannot remove column, grid config or fieldname is not specified.'));
        }
        $config->offsetUnsetByPath(sprintf(self::DATAGRID_SORTERS_NAME, $fieldName));        
    }

    /**
     * Remove multiple sorters from datagrid
     * 
     * @param DatagridConfiguration $config
     * @param array $fields
     */    
    public function removeSorters(DatagridConfiguration $config, $fields) {
        if(!is_array($fields)) {
            throw new \LogicException(sprintf('Cannot remove colums, parameter 2 is not an array.'));
        }
        
        foreach($fields as $fieldName) {
            $this->removeSorter($config, $fieldName);
        }        
    }
    
    
    /**
     * Enable or disable a single filter given the filter name and enabled flag,
     * if no flag is given, enabled will be true.
     * 
     * @param DatagridConfiguration $config
     * @param string $filterName, name of the filter (should be the same as the corresponding field)
     */
    public function enableFilter(DatagridConfiguration $config, $filterName, $enabled = true) {
        if(!$filterName || !$config) {
            throw new \LogicException(sprintf('Cannot remove column, grid config or fieldname is not specified.'));
        }
        $path = sprintf(self::DATAGRID_FILTERS_NAME, $filterName); 
        $filterConfig = $config->offsetGetByPath($path);

        $filterConfig['enabled'] = $enabled;
        
        //$enabled is false and the $filterConfig['enabled'] is true
        //if $filterConfig['enabled'] is already false and $enabled is false as well
        //there is no need to change the value in the $filterConfig
        if(!$enabled && $filterConfig['enabled']) {
            $filterConfig['enabled'] = $enabled;
        }
          
        $config->offsetSetByPath($path, $filterConfig);  
    }
    
    /**
     * Enable or disable multiple filters given an array of (fieldname) filters.
     * Below is the array which should be specified.
     * 
     * @param DatagridConfiguration $config
     * @param array $filters [ $fieldName => $enable ]
     * $fieldName as <key>, the name of the corresponding field in the datagrid
     * $enable <value>, boolean either enable or disable (true|false) the field filter
     * @throws \LogicException if the second parameter isn't an array throw exception and let the user know.
     */
    public function enableFilters(DatagridConfiguration $config, $filters) {
        if(!is_array($filters)) {
            throw new \LogicException(sprintf('Cannot sort filters, parameter 2 is not an array.'));
        }
                
        foreach($filters as $fieldName => $enabled) {
            $this->enableFilter($config, $fieldName, $enabled);         
        }       
    }    
}