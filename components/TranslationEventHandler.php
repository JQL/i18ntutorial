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
