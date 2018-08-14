# JVFurigana
### ZF2 Module for adding furigana to japanese text

Version 1.0 Created by [Julian Vidal](http://julianvidal.com/)

## What exactly is furigana?

[Furigana](http://en.wikipedia.org/wiki/Furigana) according to Wikipedia is:

>A Japanese reading aid, consisting of smaller kana, or syllabic characters, printed next to a kanji (ideographic character) or other character to indicate its pronunciation. It is typically used to clarify rare, nonstandard or ambiguous readings, or in children's or learners' materials.

Simply put, you could know how to *read* a certain word in Japanese but that doesn't necessarily mean that you know how to pronounce it. To solve this problem, publishers use furigana to tell the reader how a particular word is pronounced.

A Japanese sentence looks like this:

林さんは英語は話せます。

To add a phonetic guide it is common practice to include the pronunciations between parenthesis right after the kanji, like this:

林（はやし）さんは英語（えいご）は話（はな）せます。

While this makes pronunciations very clear it makes the text less readable.

This module takes furigana entered in the above format and converts it to proper HTML using **ruby**, **rb**, **rp**, and **rt** tags. This will turn the above sentence into this:

    <ruby><rb>林</rb><rp>(</rp><rt>はやし</rt><rp>)</rp></ruby>さんは<ruby><rb>英語</rb><rp>(</rp><rt>えいご</rt><rp>)</rp></ruby>は<ruby><rb>話</rb><rp>(</rp><rt>はな</rt><rp>)</rp></ruby>せます。

Supported browsers (like Chrome) will render it like this:

![Rendered furigana](https://julianvidal.com/images/furigana.png?1)

And a nice advantage is that browsers that don't support ruby text will degrade gracefully and render your text exactly as you entered it. Actually the text will *look* the same but since the furigana will now be wrapped in its own tags, you will be able to style them the way you want. You couldn't have done this without ruby tags. So as you see the **ruby** tag has its benefits.


## Installation

You can install this module in different ways. The easiest one is by using composer. For this to work you need to add the module to your `require` section in the composer.json file:

    "require": {
        "jv/jvfurigana": "dev-master"
    }

Then run: `php composer.phar update`

If you don't want to use composer, you can clone or download this repository into your ZF2 modules directory. 

**Whatever way you choose, don't forget to enable the module in your** `config/application.config.php` **file.**


## Usage

From within a view script, you can do:

```php
<?=$this->jvfurigana('こんにちは世界（せかい）'); ?>
```

## PERFORMANCE

The view helper needs to be initialized with a render strategy that implements the `RenderStrategyInterface`. By default it implements the `FilterStrategy` which will work fine with PHP 5.3. In some windows installs I noticed that this strategy was not catching all the furigana correctly. If that is your case, you can use the `ManualStrategy` which, as the name implies, does a lot of the work manually.

You should always use the `FilterStrategy` because it outperforms the `ManualStrategy` by far. Rendering 40 kilobytes of japanese text with `FilterStrategy` took 0.002 seconds while the `ManualStrategy` took 18.177 seconds on a MacBook Pro i7 with 16gb of ram.

## FAQ

See the github FAQ page.

## License

JVFurigana is released under the Apache license. See the included LICENSE file.
 
## VERSION HISTORY

2012-11-18 Added filter strategy
2012-11-11 First version
