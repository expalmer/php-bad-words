
## PHP Bad Words

PHP BAD WORDS is a PHP Package that return TRUE or FALSE when it finds a bad word in a text.

The cool thing is that you can put rules in each word of the dictionary.

Explanation
-------
1. **Alone**: If the text is ``You are a Asshole``, and the dictionary has the bad words ``array( 'ass' );``
  it doesn't match, because the word ``ass`` must be appears alone.
2. **Among**: The same text ``You are a Asshole`` and the same word, but now as an array with a rule ``array( array('ass','among') );``, now it matches because the rule ``among``. It will find among each word of the text by the word ``ass``, and the word ``asshole`` has the word ``ass``, got it ;).

Installing
-------
To install include it in your projects's `composer.json`.

  ```"expalmer/php-bad-words": "dev-master",```

There are no additional dependencies required for this package to work.

Usage
-------

```PHP
  /* Using Composer */
  require_once 'vendor/autoload.php';
  use \Expalmer\PhpBadWords\PhpBadWords as BadWords;

  $myDictionary = array(
    array("ass","among"),
    "anal",
    "butt"
  );

  $myText = "You are an asshole";

  $badwords = new BadWords();
  $badwords->setDictionaryFromArray( $myDictionary )
           ->setText( $myText );

  var_dump( $badwords->check() );
  // output: TRUE.
  // Because the dictionary has a word `ass` with `among` rule.

  var_dump( $badwords->checkAlone() );
  // output: FALSE.
  // Because now it verified by word `ass` alone, and it does not exist alone.
  // ( It ignores dictionary word rules )

  var_dump( $badwords->checkAmong() );
  // output: TRUE.
  // Again, it verified by `ass` among each word in the text.
  // ( It ignores dictionary word rules )

  // WITH THE WORD `anal`

  $myAnotherText = "She is not a research analyst";

  $badwords->setText( myAnotherText );

  var_dump( $badwords->check() );
  // output: FALSE.

  var_dump( $badwords->checkAlone() );
  // output: FALSE.

  var_dump( $badwords->checkAmong() );
  // output: TRUE.

```

Setting the Dictionary
-------

#### How the dictionary looks like.
```PHP
  array(
    array("ass","among"), // rule: among
    "anal",               // rule: alone
    "beastiality",        // rule: alone
    "fart",               // rule: alone
    array("vag","among")  // rule: among
  );
```

### By an Array
```PHP
  $myDictionary = array(
    array("ass","among"),
    "butt"
  );
  $bad = new PhpBadWords();
  $obj->setDictionaryFromArray( $myDictionary );
```

### By a File
```PHP
  /*
  // dictionary.php
  <?php
    return array(
      array("ass","among"),
      "anal",
      "butt"
    );
  */
  $bad = new PhpBadWords();
  $obj->setDictionaryFromFile( __DIR__ . "/dictionary.php" );

```

Tests
-------
To run the unit tests on this package, simply run `vendor/bin/phpunit` from the package directory.

-----