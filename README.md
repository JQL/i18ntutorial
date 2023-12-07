# How to add a DropDown Language Picker (i18n) to the Menu

## Adding Internationalisation to the NavBar Menu in Yii2

Yii comes with internationalisation (i18n) "out of the box". There are instructions in the manual as to how to configure Yii to use i18n, but little information all in one place on how to fully integrate it into the bootstrap menu. This document attempts to remedy that.

The Github repository also contains the language flags, some country flags, a list of languages codes and their language names and a list of the languages Yii recognises "out of the box". A video will be posted on YouTube soon.

---

Ensure that your system is set up to use i18n. From the Yii2 Manual:

> Yii uses the `PHP intl` extension to provide most of its I18N features, such as the date and number formatting of the `yii\i18n\Formatter` class and the message formatting using `yii\i18n\MessageFormatter`. Both classes provide a fallback mechanism when the intl extension is not installed. However, the fallback implementation only works well for English target language. So it is highly recommended that you install `intl` when I18N is needed.

## Create the required Files

First you need to create a configuration file.

Decide where to store it (e.g. in the `./messages/` directory with the name `create_i18n.php`). Create the directory in the project then issue the following command from **Terminal** (Windows: CMD) from the root directory of your project:

```php
./yii message/config-template ./messages/create_i18n.php
```

or for more granularity:

```php
./yii message/config --languages=en-US --sourcePath=@app --messagePath=messages ./messages/create_i18n.php
```

In the newly created file, alter (or create) the array of languages to be translated:

```php
  // array, required, list of language codes that the extracted messages
  // should be translated to. For example, ['zh-CN', 'de'].
  'languages' => [
    'en-US',
    'fr',
    'pt'
  ],
```

If necessary, change the root directory in `create_i18n.php` to point to the messages directory - the default is `messages`. Note, if the above file is in the messages directory (recommended) then don't alter this `'messagePath' => __DIR__,`. If you alter the directory for `messages` to, say, `/config/` (not a good idea) you can use the following:

```php
  // Root directory containing message translations.
  'messagePath' => __DIR__ . DIRECTORY_SEPARATOR . 'config',
```

The created file should look something like this after editing the languages you need:

```php
<?php

return [
  // string, required, root directory of all source files
  'sourcePath' => __DIR__ . DIRECTORY_SEPARATOR . '..',
  // array, required, list of language codes (in alphabetical order) that the extracted messages
  // should be translated to. For example, ['zh-CN', 'de'].
  'languages' => [
    // to localise a particular language use the language code followed by the dialect in CAPS
    'en-US',  // USA English
    'es',
    'fr',
    'it',
    'pt',
  ],
  /* 'languages' => [
    'af', 'ar', 'az', 'be', 'bg', 'bs', 'ca', 'cs', 'da', 'de', 'el', 'es', 'et', 'fa', 'fi', 'fr', 'he', 'hi',
    'pt-BR', 'ro', 'hr', 'hu', 'hy', 'id', 'it', 'ja', 'ka', 'kk', 'ko', 'kz', 'lt', 'lv', 'ms', 'nb-NO', 'nl',
    'pl', 'pt', 'ru', 'sk', 'sl', 'sr', 'sr-Latn', 'sv', 'tg', 'th', 'tr', 'uk', 'uz', 'uz-Cy', 'vi', 'zh-CN',
    'zh-TW'
    ], */
  // string, the name of the function for translating messages.
  // Defaults to 'Yii::t'. This is used as a mark to find the messages to be
  // translated. You may use a string for single function name or an array for
  // multiple function names.
  'translator' => ['\Yii::t', 'Yii::t'],
  // boolean, whether to sort messages by keys when merging new messages
  // with the existing ones. Defaults to false, which means the new (untranslated)
  // messages will be separated from the old (translated) ones.
  'sort' => false,
  // boolean, whether to remove messages that no longer appear in the source code.
  // Defaults to false, which means these messages will NOT be removed.
  'removeUnused' => false,
  // boolean, whether to mark messages that no longer appear in the source code.
  // Defaults to true, which means each of these messages will be enclosed with a pair of '@@' marks.
  'markUnused' => true,
  // array, list of patterns that specify which files (not directories) should be processed.
  // If empty or not set, all files will be processed.
  // See helpers/FileHelper::findFiles() for pattern matching rules.
  // If a file/directory matches both a pattern in "only" and "except", it will NOT be processed.
  'only' => ['*.php'],
  // array, list of patterns that specify which files/directories should NOT be processed.
  // If empty or not set, all files/directories will be processed.
  // See helpers/FileHelper::findFiles() for pattern matching rules.
  // If a file/directory matches both a pattern in "only" and "except", it will NOT be processed.
  'except' => [
    '.*',
    '/.*',
    '/messages',
    '/migrations',
    '/tests',
    '/runtime',
    '/vendor',
    '/BaseYii.php',
  ],
  // 'php' output format is for saving messages to php files.
  'format' => 'php',
  // Root directory containing message translations.
  'messagePath' => __DIR__,
  // boolean, whether the message file should be overwritten with the merged messages
  'overwrite' => true,
  /*
    // File header used in generated messages files
    'phpFileHeader' => '',
    // PHPDoc used for array of messages with generated messages files
    'phpDocBlock' => null,
   */

  /*
    // Message categories to ignore
    'ignoreCategories' => [
    'yii',
    ],
   */

  /*
    // 'db' output format is for saving messages to database.
    'format' => 'db',
    // Connection component to use. Optional.
    'db' => 'db',
    // Custom source message table. Optional.
    // 'sourceMessageTable' => '{{%source_message}}',
    // Custom name for translation message table. Optional.
    // 'messageTable' => '{{%message}}',
   */

  /*
    // 'po' output format is for saving messages to gettext po files.
    'format' => 'po',
    // Root directory containing message translations.
    'messagePath' => __DIR__ . DIRECTORY_SEPARATOR . 'messages',
    // Name of the file that will be used for translations.
    'catalog' => 'messages',
    // boolean, whether the message file should be overwritten with the merged messages
    'overwrite' => true,
   */
];
```

## Edit the `/config/web.php` file

In the `web.php` file, below `'id' => 'basic',` add:

```php
  'language' => 'en',
  'sourceLanguage' => 'en',
```

Note: you should always use the `'sourceLanguage' => 'en'` as it is, usually, easier and cheaper to translate from English into another language. If the `sourceLanguage` is not set it defaults to `'en'`.

Add the following to the `'components' => [...]` section:

```php
    'i18n' => [
      'translations' => [
        'app*' => [
          'class' => 'yii\i18n\PhpMessageSource',  // Using text files (usually faster) for the translations
          //'basePath' => '@app/messages',  // Uncomment and change this if your folder is not called 'messages'
          'sourceLanguage' => 'en',
          'fileMap' => [
            'app' => 'app.php',
            'app/error' => 'error.php',
          ],
          //  Comment out in production version
          //  'on missingTranslation' => ['app\components\TranslationEventHandler', 'handleMissingTranslation'],
        ],
      ],
    ],
```

## Edit all the files in the "views" folder and any sub folders

Now tell Yii which text you want to translate in your view files. This is done by adding `Yii::t('app', 'text to be translated')` to the code.

For example, in `/views/layouts/main.php`, change the menu labels like so:

```php
    'items' => [
          //  ['label' => 'Home', 'url' => ['/site/index']],	// Orignal code
          ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
          ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
          ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
          Yii::$app->user->isGuest ? ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']] : '<li class="nav-item">'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
             // 'Logout (' . Yii::$app->user->identity->username . ')', // change this line as well to the following:
              Yii::t('app', 'Logout ({username})'), ['username' => Yii::$app->user->identity->username]),
              ['class' => 'nav-link btn btn-link logout']
            )
            . Html::endForm()
            . '</li>',
        ],
```

## Create the texts to be translated

To create the translation files, run the following, in **Terminal**, from the root directory of your project:

```php
./yii message ./messages/create_i18n.php
```

Now, get the messages translated. For example in the French `/messages/fr/app.php`

```php
  'Home' => 'Accueil',
  'About' => 'À propos',
  ...
```

## Create a Menu Item (Dropdown) to Change the Language

This takes a number of steps.

### 1. Create an array of languages required

A `key` and a `name` is required for each language.

The `key` is the ICU language code [ISO 639.1](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes) in lowercase (with optional Country code [ISO 3166](https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes) in uppercase) e.g.

>    French: `fr` or French Canada: `fr-CA`
>
>    Portuguese: `pt` or Portuguese Brazil: `pt-BR`

The `name` is the name of the language *in that language*. e.g. for French: `'Français'`, for Japanese: `'日本の'`. *This is important* as the user may not understand the browser's current language.

In `/config/params.php` create an array named `languages` with the languages required. For example:

```php
  /* 		List of languages and their codes
   *
   * 		format:
   * 		'Language Code' => 'Language Name',
   * 		e.g.
   * 		'fr' => 'Français',
   *
   * 		please use alphabetical order of language code
   * 		Use the language name in the "user's" Language
   *            e.g.
   *            'ja' => '日本の',
   */
  'languages' => [
//    'da' => 'Danske',
//    'de' => 'Deutsche',
//    'en' => 'English', // NOT REQUIRED the sourceLanguage (i.e. the default)
    'en-GB' => 'British English',
    'en-US' => 'American English',
    'es' => 'Español',
    'fr' => 'Français',
    'it' => 'Italiano',
//    'ja' => '日本の',  // Japanese with the word "Japanese" in Kanji
//    'nl' => 'Nederlandse',
//    'no' => 'Norsk',
//    'pl' => 'Polski',
    'pt' => 'Português',
//    'ru' => 'Русский',
//    'sw' => 'Svensk',
//    'zh' => '中国的',
  ],
```

### 2. Create an Action

In `/controllers/SiteController.php`, the default controller, add an "Action" named `actionLanguage()`. This "Action" changes the language and sets a cookie so the browser "remembers" the language for page requests and return visits to the site.

```php
  /**
   * Called by the ajax handler to change the language and
   * Sets a cookie based on the language selected
   *
   */
  public function actionLanguage()
  {
    $lang = Yii::$app->request->post('lang');
    // If the language "key" is not NULL and exists in the languages array in params.php, change the language and set the cookie
    if ($lang !== NULL && array_key_exists($lang, Yii::$app->params['languages']))
    {
      $expire = time() + (60 * 60 * 24 * 365); //  1 year - alter accordingly
      Yii::$app->language = $lang;
      $cookie = new yii\web\Cookie([
        'name' => 'lang',
        'value' => $lang,
        'expire' => $expire,
      ]);
      Yii::$app->getResponse()->getCookies()->add($cookie);
    }
    Yii::$app->end();
  }
```

Remember to set the method to `POST`. In `behaviors()`, under `actions`, set `'language' => ['post'],` like so:

```php
      'verbs' => [
        'class' => VerbFilter::class,
        'actions' => [
          'logout' => ['post'],
          'language' => ['post'],
        ],
      ],
```

### 3. Create a Language Handler

Make sure that the correct language is served for each request.

In the `/components/ directory`, create a file named: `LanguageHandler.php` and add the following code to it:

```php
<?php

/*
 * Copyright ©2023 JQL all rights reserved.
 * http://www.jql.co.uk
 */
/*
  Created on : 19-Nov-2023, 13:23:54
  Author     : John Lavelle
  Title      : LanguageHandler
 */

namespace app\components;

use yii\helpers\Html;

class LanguageHandler extends \yii\base\Behavior
{

	public function events()
	{
		return [\yii\web\Application::EVENT_BEFORE_REQUEST => 'handleBeginRequest'];
	}

	public function handleBeginRequest($event)
	{
		if (\Yii::$app->getRequest()->getCookies()->has('lang') && array_key_exists(\Yii::$app->getRequest()->getCookies()->getValue('lang'), \Yii::$app->params['languages']))
		{
      //  Get the language from the cookie if set
			\Yii::$app->language = \Yii::$app->getRequest()->getCookies()->getValue('lang');
		}
		else
		{
			//	Use the browser language - note: some systems use an underscore, if used, change it to a hyphen
			\Yii::$app->language = str_replace('_', '-', HTML::encode(locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE'])));
		}
	}

}

/* End of file LanguageHandler.php */
/* Location: ./components/LanguageHandler.php */
```

### 4. Call `LanguageHandler.php` from `/config/web.php`

"Call" the `LanguageHandler.php` file from `/config/web.php` by adding the following to either just above or just below `'params' => $params,`

```php
  //	Update the language on selection
  'as beforeRequest' => [
    'class' => 'app\components\LanguageHandler',
  ],
```

### 5. Add the Language Menu Item to `/views/layouts/main.php`

`main.php` uses Bootstrap to create the menu. An item (Dropdown) needs to be added to the menu to allow the user to select a language.

Add `use yii\helpers\Url;` to the "uses" section of `main.php`.

Just above `echo Nav::widget([...])` add the following code:

```php
// Get the languages and their keys, also the current route
      foreach (Yii::$app->params['languages'] as $key => $language)
      {
        $items[] = [
          'label' => $language, // Language name in it's language - already translated
          'url' => Url::to(['site/index']), // Route
          'linkOptions' => ['id' => $key, 'class' => 'language'], // The language "key"
        ];
      }
```

In the section:

```php
echo Nav::widget([...])`
```

between

```php
'options' => ['class' => 'navbar-nav ms-auto'], // ms-auto aligns the menu right`
```

and

```php
'items' => [...]
```

add:

```php
'encodeLabels' => false, // Required to enter HTML into the labels
```

like so:

```php
      echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'], // ms-auto aligns the menu right
        'encodeLabels' => false, // Required to enter HTML into the labels
        'items' => [
          ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
        ...
```

Now add the Dropdown. This can be placed anywhere in `'items' => [...]`.

```php
// Dropdown Nav Menu: https://www.yiiframework.com/doc/api/2.0/yii-widgets-menu
        [
          'label' => Yii::t('app', 'Language')),
          'url' => ['#'],
          'options' => ['class' => 'language', 'id' => 'languageTop'],
          'encodeLabels' => false, // Optional but required to enter HTML into the labels for images
          'items' => $items, // add the languages into the Dropdown
        ],
```

The code in `main.php` for the NavBar should look something like this:

```php
      NavBar::begin([
        'brandLabel' => Yii::$app->name,  // set in /config/web.php
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
      ]);
      // Get the languages and their keys, also the current route
      foreach (Yii::$app->params['languages'] as $key => $language)
      {
        $items[] = [
          'label' => $language, // Language name in it's language
          'url' => Url::to(['site/index']), // Current route so the page refreshes
          'linkOptions' => ['id' => $key, 'class' => 'language'], // The language key
        ];
      }
      echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'], // ms-auto aligns the menu right
        'encodeLabels' => false, // Required to enter HTML into the labels
        'items' => [
          ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
          ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
          ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
          // Dropdown Nav Menu: https://www.yiiframework.com/doc/api/2.0/yii-widgets-menu
          [
            'label' => Yii::t('app', 'Language') ,
            'url' => ['#'],
            'options' => ['class' => 'language', 'id' => 'languageTop'],
            'encodeLabels' => false, // Required to enter HTML into the labels
            'items' => $items, // add the languages into the Dropdown
          ],
          Yii::$app->user->isGuest ? ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']] : '<li class="nav-item">'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
//              'Logout (' . Yii::$app->user->identity->username . ')',
              Yii::t('app', 'Logout ({username})', ['username' => Yii::$app->user->identity->username]),
              ['class' => 'nav-link btn btn-link logout']
            )
            . Html::endForm()
            . '</li>',
        ],
      ]);
      NavBar::end();
```

If Language flags or images are required next to the language name see *Optional Items* at the end of this document.

### 6. Trigger the Language change with an Ajax call

To call the Language Action `actionLanguage()` make an Ajax call in a JavaScript file.

Create a file in `/web/js/` named `language.js`.

Add the following code to the file:

```JavaScript
/*
 * Copyright ©2023 JQL all rights reserved.
 * http://www.jql.co.uk
 */

/**
 * Set the language
 *
 * @returns {undefined}
 */
$(function () {
  $(document).on('click', '.language', function (event) {
    event.preventDefault();
    let lang = $(this).attr('id');  // Get the language key
    /* if not the top level, set the language and reload the page */
    if (lang !== 'languageTop') {
      $.post(document.location.origin + '/site/language', {'lang': lang}, function (data) {
        location.reload(true);
      });
    }
  });
});
```

To add the JavaScript file to the Assets, alter `/assets/AppAsset.php` in the project directory. In `public $js = []` add `'js/language.js'`, like so:

```php
     public $js = [
       'js/language.js',
     ];
```

**Internationalisation should now be working on your project.**


---

## Optional Items

The following are optional but may help both you and/or the user.

### 1. Check for Translations

Yii can check whether a translation is present for a particular piece of text in a `Yii::t('app', 'text to be translated')` block.

There are two steps:

**A.** In `/config/web.php uncomment` the following line:

```php
  //  'on missingTranslation' => ['app\components\TranslationEventHandler', 'handleMissingTranslation'],
```

**B.** Create a TranslationEventHandler:

In `/components/` create a file named: `TranslationEventHandler.php` and add the following code to it:

```php

<?php

/**
 * TranslationEventHandler
 *
 * @copyright © 2023, John Lavelle  Created on : 14 Nov 2023, 16:05:32
 *
 *
 * Author     : John Lavelle
 * Title      : TranslationEventHandler
 */
// Change the Namespace (app, frontend, backend, console etc.) if necessary (default in Yii Basic is "app").

namespace app\components;

use yii\i18n\MissingTranslationEvent;

/**
 * TranslationEventHandler
 *
 *
 * @author John Lavelle
 * @since 1.0 // Update version number
 */
class TranslationEventHandler
{

  /**
   * Adds a message to missing translations in Development Environment only
   *
   * @param MissingTranslationEvent $event
   */
  public static function handleMissingTranslation(MissingTranslationEvent $event)
  {
    // Only check in the development environment
    if (YII_ENV_DEV)
    {
      $event->translatedMessage = "@MISSING: {$event->category}.{$event->message} FOR LANGUAGE {$event->language} @";
    }
  }
}
```

If there is a missing translation, the text is replaced with a message similar to the following text:

> @MISSING: app.Logout (John) FOR LANGUAGE fr @

Here Yii has found that there is no French translation for:

```php
Yii::t('app', 'Logout ({username})', ['username' => Yii::$app->user->identity->username]),
```

### 2. Add Language Flags to the Dropdown Menu

This is very useful and recommended as it aids the User to locate the correct language. There are a number of steps for this.

**a.** Create images of the flags.

The images should be 25px wide by 15px high. The images **must have** the same name as the language key in the language array in params.php. For example: `fr.png` or `en-US.png`. If the images are not of type ".png" change the code in part **b.** below to the correct file extension.

Place the images in a the directory `/web/images/flags/`.

**b.** Alter the code in `/views/layouts/main.php` so that the code for the "NavBar" reads as follows:

```php
<header id="header">
      <?php
      NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
      ]);
      // Get the languages and their keys, also the current route
      foreach (Yii::$app->params['languages'] as $key => $language)
      {
        $items[] = [
	// Display the image before the language name
          'label' => Html::img('/images/flags/' . $key . '.png', ['alt' => 'flag ' . $language, 'class' => 'inline-block align-middle', 'title' => $language,]) . ' ' . $language, // Language name in it's language
          'url' => Url::to(['site/index']), // Route
          'linkOptions' => ['id' => $key, 'class' => 'language'], // The language key
        ];
      }
      echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'], // ms-auto aligns the menu right
        'encodeLabels' => false, // Required to enter HTML into the labels
        'items' => [
          ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
          ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
          ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
          // Dropdown Nav Menu: https://www.yiiframework.com/doc/api/2.0/yii-widgets-menu
          [
	  // Display the current language "flag" after the Dropdown title (before the caret)
            'label' => Yii::t('app', 'Language') . ' ' . Html::img('@web/images/flags/' . Yii::$app->language . '.png', ['class' => 'inline-block align-middle', 'title' => Yii::$app->language]),
            'url' => ['#'],
            'options' => ['class' => 'language', 'id' => 'languageTop'],
            'encodeLabels' => false, // Required to enter HTML into the labels
            'items' => $items, // add the languages into the Dropdown
          ],
          Yii::$app->user->isGuest ? ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']] : '<li class="nav-item">'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
//              'Logout (' . Yii::$app->user->identity->username . ')',
              Yii::t('app', 'Logout ({username})', ['username' => Yii::$app->user->identity->username]),
              ['class' => 'nav-link btn btn-link logout']
            )
            . Html::endForm()
            . '</li>',
        ],
      ]);
      NavBar::end();
      ?>
    </header>
```

That's it! Enjoy...

For further reading and information see:

[i18ntutorial on Github](https://github.com/JQL/i18ntutorial)

[Yii2 Internationalization Tutorial](https://www.yiiframework.com/doc/guide/2.0/en/tutorial-i18n)

[PHP intl extensions](https://www.php.net/manual/en/intro.intl.php)

---

If you use this code, please credit me as follows:

> Internationalization (i18n) Menu code provided by JQL, https://visualaccounts.co.uk ©2023 JQL

---

Licence (BSD-3-Clause Licence)

Copyright Notice

> Internationalization (i18n) Menu code provided by JQL, https://visualaccounts.co.uk ©2023 JQL all rights reserved

Redistribution and use in source and binary forms with or without modification are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

Neither the names of John Lavelle, JQL, Visual Accounts nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

"ALL JQL CODE & SOFTWARE INCLUDING WORLD WIDE WEB PAGES (AND THOSE OF IT'S AUTHORS) ARE SUPPLIED 'AS IS' WITHOUT ANY WARRANTY OF ANY KIND. TO THE MAXIMUM EXTENT PERMITTED BY LAW, THE AUTHOR AND PUBLISHER AND THEIR AGENTS SPECIFICALLY DISCLAIMS ALL WARRANTIES, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE. WITH RESPECT TO THE CODE, THE AUTHOR AND PUBLISHER AND THEIR AGENTS SHALL HAVE NO LIABILITY WITH RESPECT TO ANY LOSS OR DAMAGE DIRECTLY OR INDIRECTLY ARISING OUT OF THE USE OF THE CODE EVEN IF THE AUTHOR AND/OR PUBLISHER AND THEIR AGENTS HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. WITHOUT LIMITING THE FOREGOING, THE AUTHOR AND PUBLISHER AND THEIR AGENTS SHALL NOT BE LIABLE FOR ANY LOSS OF PROFIT, INTERRUPTION OF BUSINESS, DAMAGE TO EQUIPMENT OR DATA, INTERRUPTION OF OPERATIONS OR ANY OTHER COMMERCIAL DAMAGE, INCLUDING BUT NOT LIMITED TO DIRECT, INDIRECT, SPECIAL, INCIDENTAL, CONSEQUENTIAL OR OTHER DAMAGES."
