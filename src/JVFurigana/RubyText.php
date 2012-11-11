<?php

namespace JVFurigana;

/**
 * JVFurigana\RubyText
 * 
 * A class that can convert plain japanese text into properly formatted HTML with furigana (using the ruby tag)
 * 
 * @author       Julian Vidal
 * @version      1.0
 * @link         https://github.com/poisa/JVFurigana
 * 
 */
class RubyText {

    protected $_encoding = 'UTF-8';

    protected $_text;
    protected $_processedText;

    protected $_matches = array();

    protected function _findMatches()
    {
        preg_match_all('/\(([^\)]*)\)/', $this->_text, $matches);

        // Grab match set with parentheses
        $matches = $matches[1];

        $offset = 0;
        foreach ($matches as $match) {
            $matchedPosition = mb_strpos($this->_text, $match, $offset, $this->_encoding);
            $offset = $matchedPosition + mb_strlen($match, $this->_encoding);

            $curPos = $offset - mb_strlen($match, $this->_encoding);

            $matchObject = new RubyMatch();
            $matchObject->setMatch($match);
            $matchObject->setMatchLeft($curPos);
            $matchObject->setMatchRight($offset - 1);

            $this->addMatch($matchObject);
        }
    }

    protected function _calculateRubyPositions()
    {
        foreach ($this->_matches as $match) {

            /* @var $match RubyMatch */

            if ($match->getMatchLeft() == null) {
                continue;;
            }

            $curPos = $match->getMatchLeft() - 2;
            $i = 0;
            $error = false;

            while (true) {
                
                $curChar = mb_substr($this->_text, $curPos, 1, $this->_encoding);

                // If this character is not a kanji then we've reached the 
                // leftmost kanji character. Also stop if we've reached the 
                // beginning of the string
                if (!preg_match('/\p{Han}/ux', $curChar) || $curPos == 0) {
                    break;
                }
                $curPos--;

                $i++;
                if ($i > 10) {
                    // Safeguard against searching the whole document.
                    // If we've looked this many characters back and haven't 
                    // found something other than a kanji then there is something wrong.
                    $error = true;
                    break;
                }
            }

            if (!$error) {

                if ($curPos == 0) {
                    $match->setRubyLeft(0);
                } else {
                    $match->setRubyLeft($curPos + 1);
                }

                $match->setRubyRight($match->getMatchLeft() - 2);
            }
        }
    }

    protected function _insertRubyTags()
    {
        foreach ($this->_matches as $match) {

            /* @var $match RubyMatch */
            if ($match->getRubyLeft() === null) {
                continue;
            }

            $this->_insertString(RubyTag::RUBY_OPEN, $match->getRubyLeft());
            $this->_insertString(RubyTag::RUBY_CLOSE, $match->getMatchRight() + 2);
  
            $this->_insertString(RubyTag::RB_OPEN, $match->getRubyLeft());
            $this->_insertString(RubyTag::RB_CLOSE, $match->getRubyRight() + 1);

            $this->_insertString(RubyTag::RT_OPEN, $match->getMatchLeft());
            $this->_insertString(RubyTag::RT_CLOSE, $match->getMatchRight() + 1);
        }
    }
    
    protected function _replaceParenthesis()
    {
        $this->_processedText = str_replace('(', RubyTag::RP_LEFT, $this->_processedText);
        $this->_processedText = str_replace(')', RubyTag::RP_RIGHT, $this->_processedText);
    }

    protected function _insertString($string, $position)
    {
        $pre = mb_substr($this->_processedText, 0, $position, $this->_encoding);
        $postLength = mb_strlen($this->_processedText, $this->_encoding) - mb_strlen($pre, $this->_encoding);
        $post = mb_substr($this->_processedText, $position, $postLength, $this->_encoding);
        $this->_processedText = $pre . $string . $post;
        RubyMatch::offsetCollectionBy($this->_matches, mb_strlen($string, $this->_encoding), $position);
    }

    public function getEncoding() {
        return $this->_encoding;
    }

    public function setEncoding($encoding) {
        $this->_encoding = $encoding;
    }

    public function getText()
    {
        return $this->_text;
    }

    public function setText($text)
    {
        $text = str_replace(array('（', '）'), array('(', ')'), $text);
        $this->_text = $text;
        $this->_processedText = $text;
        $this->_findMatches();
        $this->_calculateRubyPositions();
        $this->_insertRubyTags();
        $this->_replaceParenthesis();
    }

    public function getProcessedText()
    {
        return $this->_processedText;
    }

    public function setProcessedText($processedText)
    {
        $this->_processedText = $processedText;
    }

    public function addMatch(RubyMatch $match)
    {
        $this->_matches[] = $match;
    }

    public function removeMatchAtIndex($index)
    {
        if (isset($this->_matches[$index])) {
            unset ($this->_matches[$index]);
        }
    }
}
