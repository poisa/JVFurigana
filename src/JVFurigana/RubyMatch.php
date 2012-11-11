<?php

namespace JVFurigana;



/**
 * Represents a ruby text match, meaning when the parser detects something like this:
 * 
 *        飛行機（ひこうき）
 * 
 * A ruby match is defined by a kanji followed IMMEDIATELY by some text enclosed in parenthesis.
 * Any spaces in between will result in the string not being considered as a ruby match. 
 * Note that when writing in hiragana, the parenthesis character is different than the one 
 * in romaji so it might look like there is a space, but there isn't. See this example:
 * 
 *        雨（あめ） is CORRECT as there is no space between the kanji and parenthesis
 *        雨 （あめ）is INCORRECT as there is a space between the kanji and parenthesis
 * 
 * 
 * @author       Julian Vidal
 * @version      1.0
 * @link         https://github.com/poisa/JVFurigana
 * 
 */
class RubyMatch
{
    protected $_matchString;

    protected $_matchLeft;
    protected $_matchRight;
    
    protected $_rubyLeft;
    protected $_rubyRight;

    public function __construct() {
    }

    public function offsetMatchBy($numberOfChars)
    {
        $this->_matchLeft  += $numberOfChars;
        $this->_matchRight += $numberOfChars;
    }

    public function offsetRubyBy($numberOfChars)
    {
        $this->_rubyLeft   += $numberOfChars;
        $this->_rubyRight  += $numberOfChars;
    }
    
    public function __toString() {
        return sprintf("[%s-%s] %s", $this->_matchLeft, $this->_matchRight, $this->_matchString);
    }

    static public function offsetCollectionBy(&$collection, $numberOfChars, $ifLeftPositionGreaterThan)
    {
        $newCollection = array();
        foreach ($collection as $match) {
            
            /* @var $match RubyMatch */
            
            if ($match->getMatchLeft() >= $ifLeftPositionGreaterThan) {
                $match->offsetMatchBy($numberOfChars);
            }

            if ($match->getRubyLeft() >= $ifLeftPositionGreaterThan) {
                $match->offsetRubyBy($numberOfChars);
            }

            $newCollection[] = $match;
        }
        return $newCollection;
    }
    
    public function getMatch() {
        return $this->_matchString;
    }

    public function setMatch($match) {
        $this->_matchString = $match;
    }

    public function getMatchLeft() {
        return $this->_matchLeft;
    }

    public function setMatchLeft($matchLeft) {
        $this->_matchLeft = $matchLeft;
    }

    public function getMatchRight() {
        return $this->_matchRight;
    }

    public function setMatchRight($matchRight) {
        $this->_matchRight = $matchRight;
    }

    public function getRubyLeft() {
        return $this->_rubyLeft;
    }

    public function setRubyLeft($rubyLeft) {
        $this->_rubyLeft = $rubyLeft;
    }

    public function getRubyRight() {
        return $this->_rubyRight;
    }

    public function setRubyRight($rubyRight) {
        $this->_rubyRight = $rubyRight;
    }
}