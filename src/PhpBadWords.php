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
  private $dictionaryWords = array();

  public function __construct( $dictionaryFilePath = false ) {
    if( $dictionaryFilePath ) {
      $this->dictionary = $this->setDictionary( $dictionaryFilePath );
    }
    foreach($this->dictionary as $w):
      $this->dictionaryWords[] = is_array($w) ? $w[0] : $w;
    endforeach;
  }

  /**
   * setDictionary function.
   * Get the bad words list from a custom file
   *
   * @access private
   * @return array
   * @throws \Exception
   */
  private function setDictionary( $path ) {
    $dict = false;
    if (file_exists( $path ) ) {
      $dict = include $path;
      if( !is_array($dict) ) {
        throw new \Exception('The file content must be an array!');
      }
      return $dict;
    }
    throw new \Exception('File not found in ' . $path );
  }


  /**
   * setText function.
   *
   * @param string
   * @access public
   * @return this
   */

  public function setText( $text ) {
    $this->text = $text;
    return $this;
  }

  /**
   * check function.
   *
   * @access public
   * @return boolean Is the string has a bad word in context of the dictionary rules
   */
  public function check() {

    foreach( $this->dictionary as $word ):
      $rule = "alone";
      if( is_array($word) ) {
        $rule = isset($word[1]) ? $word[1] : $rule;
        $word = $word[0];
      }
      if( "among" === $rule ) {
        if( preg_match("/(" . $word . ")/i", $this->text ) ) return true;
      } else {
        if( preg_match("/(\b)+(" . $word . ")+(\b)/i", $this->text ) ) return true;
      }
    endforeach;
    return false;
  }

  /**
   * checkAmong function.
   *
   * @access public
   * @return boolean Is the string has a bad word among a word
   */
  public function checkAmong() {
    return preg_match("/(" . join("|", $this->dictionaryWords ) . ")/i", $this->text );
  }

  /**
   * checkAlone function.
   *
   * @access public
   * @return boolean Is the string has a bad word exactly
   */
  public function checkAlone() {
    return preg_match("/(\b)+(" . join("|", $this->dictionaryWords ) . ")+(\b)/i", $this->text );
  }

}
