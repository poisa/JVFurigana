<?php

namespace JVFurigana\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
use JVFurigana\RubyText;

class Furigana extends AbstractHelper
{
    public function __invoke($string = null)
    {
        $parser = new RubyText();
        $parser->setText($string);
        return $parser->getProcessedText();
    }
}