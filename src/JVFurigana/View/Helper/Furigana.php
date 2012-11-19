<?php

namespace JVFurigana\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
use JVFurigana\RenderStrategy\RenderStrategyInterface;

class Furigana extends AbstractHelper
{
    protected $_renderStrategy;
    
    public function __construct(RenderStrategyInterface $renderStrategy) {
        $this->_renderStrategy = $renderStrategy;
    }
    
    public function __invoke($string = null)
    {
        $this->_renderStrategy->setText($string);
        return $this->_renderStrategy->getProcessedText();
    }
}