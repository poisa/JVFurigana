<?php

namespace JVFurigana\RenderStrategy;

interface RenderStrategyInterface {

    /**
     * @return string String containing HTML ruby text
     */
    public function getProcessedText();

    /**
     * Expects some japanese text with furigana in the proper format
     * 
     * @param string $text
     */
    public function setText($text);
}
