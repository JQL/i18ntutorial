<?php

/**
 * Basic PHP File for LanguageHandler
 *
 * @copyright © 2023, John Lavelle  Created on : 5 Dec 2023, 16:48:17
 *
 * No part of this site may be reproduced without prior permission.
 *
 * Author     : John Lavelle
 * Title      : LanguageHandler
 */
// Change the Namespace (app, frontend, backend, console etc.) Default is "app".

namespace app\components;

use Yii;
use yii\helpers\Html;

/**
 * LanguageHandler //add more information about this file
 *
 * @author John Lavelle
 * @since 1.0 // Update version number
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
      \Yii::$app->language = \Yii::$app->getRequest()->getCookies()->getValue('lang');
    }
    else
    {
      //	Use the browser language
      \Yii::$app->language = str_replace('_', '-', HTML::encode(locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE'])));
    }
  }
}
