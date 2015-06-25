<?php
namespace Expalmer\PhpBadWords;

class PhpBadWordsTest extends \PHPUnit_Framework_TestCase {

  public function testCustomDictionaryFromArray() {
    $obj = new PhpBadWords();
    $obj->setDictionaryFromArray( array("hell") );
    $obj->setText("what a hell is going on");
    $this->assertEquals( true , $obj->check() );
  }

  public function testCustomDictionaryFromArrayException() {
    $this->setExpectedException('Exception');
    $obj = new PhpBadWords();
    $obj->setDictionaryFromArray( "hell" );
  }

  public function testCustomDictionaryFromFile() {
    $obj = new PhpBadWords();
    $obj->setDictionaryFromFile( __DIR__ . "/dictionary.php" );
    $obj->setText("click the button");
    $this->assertEquals( true , $obj->check() );
  }

  public function testCustomDictionaryFromFileException() {
    $this->setExpectedException('Exception');
    $obj = new PhpBadWords();
    $obj->setDictionaryFromFile( __DIR__ . "/dictionary2.php" );
  }

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
    $obj->setText("you have an ass ßitch");
    $this->assertEquals( true , $obj->checkAlone() );
  }

  public function testCheckAmongJokeWords_true() {
    $obj = new PhpBadWords();
    $obj->setText("Y.o.u A.r.e Am A-s-s.H.O.L.e");
    $this->assertEquals( true , $obj->check() );
  }

  public function testEmailInText() {
    $obj = new PhpBadWords();
    $obj->setDictionaryFromFile( __DIR__ . "/dictionary.php" );
    $obj->setText("I sent to you an email to a-email-address@gmail.com ok");
    $this->assertEquals( true , $obj->check() );
  }

}