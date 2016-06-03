<?php
namespace Expalmer\PhpBadWords;

class PhpBadWords {

  private $dictionary = array(
    "anal",
    "ass",
    array("asshole", "among"),
    "butt"
  );

  private $text;
  private $textOriginal;
  private $dictionaryWords = array();

  public function __construct() {
    $this->fillDictionaryWords();
  }

  /**
   * Fill the variable with only the words of the dictionary, without the original word rules
   *
   * @return void
   */
  private function fillDictionaryWords() {
    foreach($this->dictionary as $w):
      $this->dictionaryWords[] = is_array($w) ? $w[0] : $w;
    endforeach;
  }

  /**
   * Set the bad words list from an array
   *
   * @param  array
   * @return this
   * @throws \Exception
   */
  public function setDictionaryFromArray( $array ) {
    if( is_array($array) ) {
      $this->dictionary = $array;
      $this->fillDictionaryWords();
      return $this;
    }
    throw new \Exception('Invalid dictionary, try to send an array or a file path!');
  }

  /**
   * Set the bad words list from a file
   *
   * @param  string
   * @return this
   * @throws \Exception
   */
  public function setDictionaryFromFile( $path ) {
    if ( file_exists( $path ) ) {
      $dict = include $path;
      if( is_array($dict) ) {
        $this->dictionary = $dict;
        $this->fillDictionaryWords();
        return $this;
      }
      throw new \Exception('The file content must be an array!');
    }
    throw new \Exception('File not found in ' . $path );
  }

  /**
   * Set the text to be checked
   *
   * @param string
   * @return this
   */
  public function setText( $text ) {
    $this->textOriginal = $text;
    $this->text = preg_replace("/([^\w ]*)/iu", "", $text);
    return $this;
  }

  /**
   * Checks for bad words in the text but verifies each dictionary word rule,
   * like alone ou among each word in the text.
   *
   * @return boolean
   */
  public function check() {
    foreach( $this->dictionary as $word ):
      $rule = "alone";
      if( is_array($word) ) {
        $rule = isset($word[1]) ? $word[1] : $rule;
        $word = $word[0];
      }
      $word = preg_replace("/([^\w ]*)/iu", "", $word);
      if( "among" === $rule ) {
        if( preg_match("/(" . $word . ")/iu", $this->text ) ) return true;
      } else {
        if( preg_match("/(\b)+(" . $word . ")+(\b)/iu", $this->text ) ) return true;
      }
    endforeach;
    return false;
  }

  /**
   * Checks if the text has a bad word among each word
   *
   * @return boolean
   */
  public function checkAmong() {
    return !!preg_match("/(" . join("|", $this->dictionaryWords ) . ")/iu", $this->text );
  }

  /**
   * Checks if the text has a bad word exactly how it appears in the dictionary
   *
   * @return boolean
   */
  public function checkAlone() {
    return !!preg_match("/(\b)+(" . join("|", $this->dictionaryWords ) . ")+(\b)/iu", $this->text );
  }

}
