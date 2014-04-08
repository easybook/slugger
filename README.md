Slugger
=======

**[slugger](http://github.com/easybook/slugger)** is a fast PHP library to
generate *slugs*, which allows to safely include any string as part of an URL.
Slugs are commonly used for CMS, blogs and other content-related platforms.

Installation
------------

The easiest way to install **slugger** is to add this library as a dependency 
of your project using [Composer](https://getcomposer.org/):

```
$ cd your-project/
$ composer require easybook/slugger 1.*
```

If you prefer, add the new dependency by hand to your `composer.json` file and
then, execute the `composer update` command to update your dependencies:

```json
{
    "name"        : "...",
    "description" : "...",
    "require": {
        "php"              : ">=5.3.3",
        "easybook/slugger" : "1.0.*"
    }
}
```

## Generating slugs

Most slugger libraries include a lot of settings to configure how the slugs are
generated. **slugger** uses a different approach to offer both a great 
performance and enough flexibility: it includes four different slugger classes!

  * `Slugger`, fast slugs suited for most European languages.
  * `Utf8Slugger`, UTF-8-compliant slugger suitable for any alphabet (including
    japanese, arabic and hebrew languages). It requires PHP 5.4.0 or higher.
  * `SeoSlugger`, advanced slugger that augments the strings before turning
    them into slugs. For instance, the string `The product #3 costs $9.99` is
    turned into `the-product-number-3-costs-9-dollars-99-cents.
  * `SeoUtf8Slugger`, combines the `Utf8Slugger` and the `SeoSlugger` to
    augment and slugify any UTF-8 string.

All sluggers implement the `SluggerInterface` interface, which allows you to
safely switch in your projects from one slugger to another.

### Generating basic slugs

The easiest way to generate slugs is to use the `slugify()` method of the
`Slugger` class:

```php
use Easybook\Slugger;

$slugger = new Slugger();
$slug = $slugger->slugify('Lorem Ipsum'); // slug = lorem-ipsum
```

If you use PHP 5.5.0 or higher, you can generate slugs with a single line of 
code:

```php
$slugger = (new \Easybook\Slugger())->slugify('Lorem Ipsum');
```

### Generating unique slugs

If you need to ensure the uniqueness of the slugs generated during the 
execution of your application, use the `uniqueSlugify()`, which appends a
random suffix to the slug:

```php
use Easybook\Slugger;

$slugger = new Slugger();
$slug = $slugger->uniqueSlugify('Lorem Ipsum'); // slug = lorem-ipsum-a2b342f
```

Keep in mind that the generation of the unique slugs is non-deterministic,
meaning that the appended suffix is random and it will change in each 
application execution, even when using the same input string.

If you want to append an autoincremental numeric suffix to the slugs, you'll
need to develop your own custom solution.

### Generating slugs for complex languages

If the strings contain characters belonging to complex languages such as 
Arabic, Hebrew and Japanese, you should use the `Utf8Slugger` class. This
slugger requires PHP 5.4.0 or higher because it uses the built-in PHP
transliterator: 

```php
use Easybook\Utf8Slugger;

$slugger = new Utf8lugger();
$slug = $slugger->slugify('日一国会'); // slug = ri-yi-guo-hui
$slug = $slugger->slugify('ضطظع');    // slug = fqklmnhwyy
$slug = $slugger->slugify('נסעףפ');   // slug = wwwyyy
```

`Utf8Slugger` also defines the `uniqueSlugify()` to generate unique slugs.

### Generating SEO slugs

The `SeoSlugger` (and the related `SeoUtf8Slugger`) augments the strings
before turning them into slugs. The conversions are related to numbers,
currencies, email addresses and other common symbols:

```php
use Easybook\SeoSlugger;

$slugger = new SeoSlugger();

$slug = $slugger->slugify('The price is $5.99');
// slug = the-price-is-5-dollars-99-cents

$slug = $slugger->slugify('Use lorem@ipsum.com to get a 10% discount');
// slug = use-lorem-at-ipsum-dot-com-to-get-a-10-percent-discount

$slug = $slugger->slugify('Gravity = 9.81 m/s2');
// slug = gravity-equals-9-dot-81-m-s2
```

`SeoSlugger` and `SeoUtf8Slugger` also define the `uniqueSlugify()` to 
generate unique slugs.

Configuration options
---------------------

The only configuration option defined by **slugger** is the `separator` 
character (or string) used to separate each of the slug parts. First, you can
set this parameter globally using the class constructor:

```php
use Easybook\Slugger;

$slugger = new Slugger();
$slug = $slugger->slugify('Lorem Ipsum'); // slug = lorem-ipsum

$slugger = new Slugger('_');
$slug = $slugger->slugify('Lorem Ipsum'); // slug = lorem_ipsum

$slugger = new Slugger('');
$slug = $slugger->slugify('Lorem Ipsum'); // slug = loremipsum
```

You can also set this parameter as the second optional argument of the
`slugify()` and `uniqueSlugify()` methods. This parameter always overrides
any global parameter set by the class:

```php
use Easybook\Slugger;

$slugger = new Slugger();
$slug = $slugger->slugify('Lorem Ipsum', '_'); // slug = lorem_ipsum
$slug = $slugger->slugify('Lorem Ipsum', '');  // slug = loremipsum

$slugger = new Slugger('+');
$slug = $slugger->slugify('Lorem Ipsum', '_'); // slug = lorem_ipsum
```

License
-------

**slugger** library is licensed under the [MIT license](LICENSE.md).

Tests
-----

The library is fully unit tested. If you have [PHPUnit](http://phpunit.de/) 
installed, execute `phpunit` command to run the complete test suite:

```
$ cd slugger/
$ phpunit
PHPUnit 3.7.32 by Sebastian Bergmann.

Configuration read from slugger/phpunit.xml.dist

.........................................................  63 / 103 ( 61%)
........................................

Time: 2.12 seconds, Memory: 2.00Mb

OK (103 tests, 499 assertions)
```

Code Quality Assurance
----------------------

| SensioLabs Insight | Travis CI | Scrutinizer CI
| ------------------ | --------- | --------------
| [![SensioLabsInsight](https://insight.sensiolabs.com/projects/e6ba1358-ea76-4a51-aa44-9965db97d0ad/big.png)](https://insight.sensiolabs.com/projects/e6ba1358-ea76-4a51-aa44-9965db97d0ad) | [![Travis CI status](https://secure.travis-ci.org/easybook/slugger.png?branch=master)](http://travis-ci.org/easybook/slugger) | [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/easybook/slugger/badges/quality-score.png?s=84faa7ae33c525f6deee2f93cfad59bc63b7189e)](https://scrutinizer-ci.com/g/easybook/slugger/)
