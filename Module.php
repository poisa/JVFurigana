<?php

namespace JVFurigana;

class Module
{
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'jvfurigana' => function($sm) {
                    $locator = $sm->getServiceLocator(); // $sm is the view helper manager, so we need to fetch the main service manager
                    return new \JVFurigana\View\Helper\Furigana($locator->get('jvfurigana_filterStrategy'));
                    },
                ),
        );
    }    
    
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'jvfurigana_manualStrategy' => 'JVFurigana\RenderStrategy\ManualStrategy',
                'jvfurigana_filterStrategy' => 'JVFurigana\RenderStrategy\FilterStrategy'
            ),
        );
        
    }

}
