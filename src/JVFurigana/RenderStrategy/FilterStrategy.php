<?php

namespace JVFurigana\RenderStrategy;

/**
 * JVFurigana\ManualStrategy
 * 
 * A class that can convert plain japanese text into properly formatted HTML with furigana (using the ruby tag)
 * This class parses the japanese text using regular expressions alone.
 * 
 * @author       Julian Vidal
 * @version      1.1
 * @link         https://github.com/poisa/JVFurigana
 * 
 */
class FilterStrategy implements RenderStrategyInterface {

    protected $_text;


    public function setText($text)
    {
        $this->_text = $text;
    }

    public function getProcessedText()
    {
        $pattern = '/' . 
                   '([\p{Han}]+)' .           // One or more kanji
                   '（([\p{Hiragana}]*)）' .   // Hiragana between japanese style parentheses 
                   '/u';
        
        return preg_filter($pattern, '<ruby><rb>$1</rb><rp>(</rp><rt>$2</rt><rp>)</rp></ruby>', $this->_text);        
    }

}
