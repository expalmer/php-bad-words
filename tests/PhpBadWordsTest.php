<?php
namespace Expalmer\PhpBadWords;

class PhpBadWordsTest extends \PHPUnit_Framework_TestCase {

  public function testCheck_true() {
    $obj = new PhpBadWords();
    $obj->setText("you have an ass");
    $this->assertEquals( true , $obj->check() );
  }

  public function testCheck_false() {
    $obj = new PhpBadWords();
    $obj->setText("she is an assistant professor");
    $this->assertEquals( false , $obj->check() );
  }

  public function testCheckAmong_true() {
    $obj = new PhpBadWords();
    $obj->setText("she is an assistant professor");
    $this->assertEquals( true , $obj->checkAmong() );
  }

  public function testCheckAlone_true() {
    $obj = new PhpBadWords();
    $obj->setText("you have an ass");
    $this->assertEquals( true , $obj->checkAlone() );
  }

  public function testCustomDictionary_true() {
    $obj = new PhpBadWords( __DIR__ . "/dictionary.php" );
    $obj->setText("you are an assistent");
    $this->assertEquals( true , $obj->check() );
  }

  public function testCustomDictionary_false() {
    $obj = new PhpBadWords( __DIR__ . "/dictionary.php" );
    $obj->setText("you are an assistent");
    $this->assertEquals( false , $obj->checkAlone() );
  }

  public function testCustomDictionary_false_1() {
    $obj = new PhpBadWords( __DIR__ . "/dictionary.php" );
    $obj->setText("you have an ass");
    $this->assertEquals( true , $obj->checkAlone() );
  }

}