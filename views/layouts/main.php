<?php
/** @var yii\web\View $this */

/** @var string $content */
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
  <head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
  </head>
  <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
      <?php
      NavBar::begin([
        'brandLabel' => Yii::$app->name, // set in /config/web.php
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

    <main id="main" class="flex-shrink-0" role="main">
      <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
          <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
      </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
      <div class="container">
        <div class="row text-muted">
          <div class="col-md-6 text-center text-md-start">&copy; <?= Html::encode(Yii::$app->name) ?> <a href="https://www.visualaccounts.co.uk" target="_blank">https://www.visualaccounts.co.uk</a> <?= date('Y') ?></div>
          <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
      </div>
    </footer>

    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>
