<?php

defined('_JEXEC') or die;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;
use Joomla\Database\DatabaseInterface;

/** @var SiteApplication **/
$app = Factory::getApplication();
$document = $app->getDocument();

define('NEWTRALIZE_FILE', JPATH_SITE . "/templates/" . $this->template);
define('NEWTRALIZE_BASE', "/templates/" . $this->template);
$timestamp = date('U');

$this->setHtml5(true);

// Get active menu item alias
$active = $app->getMenu()->getActive();

$activeCategory = null;
if ($active->query['option'] === "com_content" && $active->query['view'] === "article") {
  /** @var DatabaseInterface **/
  $db = Factory::getContainer()->get(DatabaseInterface::class);
  $query = $db->getQuery(true);
  $query
    ->select($db->quoteName(['b.id', 'b.alias']))
    ->from($db->quoteName('#__content', 'a'))
    ->join("INNER", $db->quoteName('#__categories', 'b') . " ON " . $db->quoteName('a.catid') . " = " . $db->quoteName('b.id'))
    ->where($db->quoteName('a.id') . " = " . $db->quote($active->query['id']));
  $db->setQuery($query);
  $activeCategory = $db->loadObject();
}

$params = $app->getTemplate(true)->params;

$sitetitle = $app->get('sitename');

// Site Settings
$logo = $params->get('logo', '');
$showFooterLogo = $params->get('showFooterLogo', '1') === '1';
$differentFooterLogo = $params->get('differentFooterLogo', '1') === '1';
$footerLogo = $differentFooterLogo ? $params->get('footerLogo', '') : $logo;
$showCopyright = $params->get('showCopyright', '1') === '1';
$copyrightText = $params->get('copyrightText', '');

// Cache Settings
$sendNoCacheHeaders = $params->get('noCacheHeaders', '0') === '1';
$uncacheCss = $params->get('uncacheCss', '0') === '1';
$uncacheJs = $params->get('uncacheJs', '0') === '1';

// CSS, JS, and Heads Settings
$scopeCssBy = $params->get('scopeCssBy', 'alias');
$scopeJsBy = $params->get('scopeJsBy', 'alias');
$scopeHeadsBy = $params->get('scopeHeadsBy', 'alias');

// Tracking Settings
$gtmCode = $params->get('gtmCode', '');
$gaCode = $params->get('gaCode', '');
$metaCode = $params->get('metaCode', '');

// Icons Settings
$fontAwesomeKit = $params->get('fontAwesomeKit', '');

// Layout Settings
$paddingInline = $params->get('paddingInline', '1');
$containerNormal = $params->get('containerNormal', '64');
$containerWide = $params->get('containerWide', '75');
$bannerSize = $params->get('bannerSize', 'normal');
$navbarSize = $params->get('navbarSize', 'normal');
$aboveBodySize = $params->get('aboveBodySize', 'normal');
$mainBodySize = $params->get('mainBodySize', 'normal');
$belowBodySize = $params->get('belowBodySize', 'normal');
$footerSize = $params->get('footerSize', 'normal');

// Module Position Settings
$showBanner = $params->get('banner', '1') === '1';
$showNavbar = $params->get('navbar', '1') === '1';
$showAboveBody = $params->get('aboveBody', '1') === '1';
$showLeftBody = $params->get('leftBody', '1') === '1';
$showMainBodyTop = $params->get('mainBodyTop', '1') === '1';
$showMainBodyBottom = $params->get('mainBodyBottom', '1') === '1';
$showRightBody = $params->get('rightBody', '1') === '1';
$showBelowBody = $params->get('belowBody', '1') === '1';
$showFooter = $params->get('footer', '1') === '1';

// Custom Code Settings
$codeAfterHead = $params->get('codeAfterHead', '');
$codeBeforeHead = $params->get('codeBeforeHead', '');
$codeAfterBody = $params->get('codeAfterBody', '');
$codeBeforeBody = $params->get('codeBeforeBody', '');

if ($sendNoCacheHeaders) {
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
}

?>

<!DOCTYPE html>
<html lang="<?= $this->language; ?>" dir="<?= $this->direction; ?>">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <jdoc:include type="head" />
    
    <?php if ($codeAfterHead) echo $codeAfterHead; ?>

    <meta name="apple-mobile-web-app-capable" content="YES" />
    
    <?php $this->setGenerator(null); ?>

    <script src="<?= NEWTRALIZE_BASE . "/js/template.js" . ($uncacheJs ? "?v=$timestamp" : ""); ?>"></script>
  
    <?php 
      $customJs = "/js/custom.js";
      if (file_exists(NEWTRALIZE_FILE . $customJs)) : 
    ?>
      <script src="<?= NEWTRALIZE_BASE . $customJs . ($uncacheJs ? "?v=$timestamp" : ""); ?>"></script>
    <?php endif; ?>

    <?php 
      $menuJs = "/js/menus/" . $active->menutype . ".js";
      if (file_exists(NEWTRALIZE_FILE . $menuJs)) : 
    ?>
      <script src="<?= NEWTRALIZE_BASE . $menuJs . ($uncacheJs ? "?v=$timestamp" : ""); ?>"></script>
    <?php endif; ?>

    <?php 
      $categoryJs = "/js/categories/" . ($scopeJsBy === 'id' ? $activeCategory->id : $activeCategory->alias) . ".js";
      if (file_exists(NEWTRALIZE_FILE . $categoryJs)) : 
    ?>
      <script src="<?= NEWTRALIZE_BASE . $categoryJs . ($uncacheJs ? "?v=$timestamp" : ""); ?>"></script>
    <?php endif; ?>

    <?php
      $pageJs = "/js/pages/" . ($scopeJsBy === 'id' ? $active->id : $active->alias) . ".js";
      if (file_exists(NEWTRALIZE_FILE . $pageJs)) : 
    ?>
      <script src="<?= NEWTRALIZE_BASE . $pageJs . ($uncacheJs ? "?v=$timestamp" : ""); ?>"></script>
    <?php endif; ?>

    <?php if ($gtmCode) : ?>
      <!-- Google Tag Manager -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','<?= $gtmCode; ?>');</script>
			<!-- End Google Tag Manager -->
    <?php endif; ?>

    <?php if ($gaCode) : ?>
      <!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $gaCode; ?>"></script>
			<script>
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());
				gtag('config', '<?= $gaCode; ?>');
			</script>
    <?php endif; ?>

    <?php if ($metaCode) : ?>
      <!-- Facebook Pixel Code -->
			<script>
				!function(f,b,e,v,n,t,s)
				{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
				n.callMethod.apply(n,arguments):n.queue.push(arguments)};
				if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
				n.queue=[];t=b.createElement(e);t.async=!0;
				t.src=v;s=b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t,s)}(window, document,'script',
				'https://connect.facebook.net/en_US/fbevents.js');
				fbq('init', '<?= $metaCode; ?>');
				fbq('track', 'PageView');
			</script>
			<noscript>
				<img height="1" width="1" style="display:none" 
						src="https://www.facebook.com/tr?id=<?= $metaCode; ?>&ev=PageView&noscript=1"/>
			</noscript>
			<!-- End Facebook Pixel Code -->
    <?php endif; ?>

    <style>
      body > .container {
        --_padding-inline: <?= $paddingInline; ?>rem;
        --_container-normal: <?= $containerNormal; ?>rem;
        --_container-wide: <?= $containerWide; ?>rem;
      }
    </style>

    <link rel="stylesheet" href="<?= NEWTRALIZE_BASE . "/css/template.css" . ($uncacheCss ? "?v=$timestamp" : ""); ?>" type="text/css">

    <?php
      $customCss = "/css/custom.css";
      if (file_exists(NEWTRALIZE_FILE . $customCss)) : 
    ?>
      <link rel="stylesheet" href="<?= NEWTRALIZE_BASE . $customCss . ($uncacheCss ? "?v=$timestamp" : ""); ?>" type="text/css">
    <?php endif; ?>

    <?php
      $menuCss = "/css/menus/" . $active->menutype . ".css";
      if (file_exists(NEWTRALIZE_FILE . $menuCss)) : 
    ?>
      <link rel="stylesheet" href="<?= NEWTRALIZE_BASE . $menuCss . ($uncacheCss ? "?v=$timestamp" : ""); ?>" type="text/css">
    <?php endif; ?>

    <?php
      $categoryCss = "/css/categories/" . ($scopeCssBy === 'id' ? $activeCategory->id : $activeCategory->alias) . ".css";
      if (file_exists(NEWTRALIZE_FILE . $categoryCss)) : 
    ?>
      <link rel="stylesheet" href="<?= NEWTRALIZE_BASE . $categoryCss . ($uncacheCss ? "?v=$timestamp" : ""); ?>" type="text/css">
    <?php endif; ?>

    <?php
      $pageCss = "/css/pages/" . ($scopeCssBy === 'id' ? $active->id : $active->alias) . ".css";
      if (file_exists(NEWTRALIZE_FILE . $pageCss)) : 
    ?>
      <link rel="stylesheet" href="<?= NEWTRALIZE_BASE . $pageCss . ($uncacheCss ? "?v=$timestamp" : ""); ?>" type="text/css">
    <?php endif; ?>
    
    <?php if ($fontAwesomeKit) : ?>
      <script defer src="<?= $fontAwesomeKit; ?>"></script>
    <?php endif; ?>

    <?php if ($codeBeforeHead) echo $codeBeforeHead; ?>
  </head>

  <?php 
    $menuHead = NEWTRALIZE_FILE . "/heads/menus/" . $active->menutype . ".php";
    if (file_exists($menuHead)) {
      include($menuHead);
    }
  ?>

  <?php 
    $categoryHead = NEWTRALIZE_FILE . "/heads/categories/" . ($scopeHeadsBy === 'id' ? $activeCategory->id : $activeCategory->alias) . ".php";
    if (file_exists($categoryHead)) {
      include($categoryHead);
    }
  ?>

  <?php 
    $pageHead = NEWTRALIZE_FILE . "/heads/pages/" . ($scopeHeadsBy === 'id' ? $active->id : $active->alias) . ".php";
    if (file_exists($pageHead)) {
      include($pageHead);
    }
  ?>

  <body
    data-menu="<?= $active->menutype; ?>"
    data-category="<?= $activeCategory->alias; ?>"
    data-page="<?= $active->alias; ?>"
  >
    <?php if ($gtmCode) : ?>
      <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= $gtmCode; ?>"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
    <?php endif; ?>

    <?php if ($codeAfterBody) echo $codeAfterBody; ?>

    <div class="container">
      <?php if ($showBanner) : ?>
        <div class="banner-wrapper container-full">
          <div class="banner <?= $bannerSize !== "container-full" ? "container-$bannerSize" : ""; ?>">
            <jdoc:include type="modules" name="banner" style="default" />
          </div>
        </div>
      <?php endif; ?>

      <?php if ($showNavbar) : ?>
        <header class="navbar-wrapper container-full">
          <div class="navbar <?= $navbarSize !== "container-full" ? "container-$navbarSize" : ""; ?>">
            <a
              class="logo"
              href="<?= $this->baseurl; ?>"
            >
              <img
                src="<?= $this->baseurl; ?>/<?= htmlspecialchars($logo); ?>"
                alt="<?= htmlspecialchars($sitetitle); ?>"
              />
            </a>
            <nav class="nav-end">
              <jdoc:include type="modules" name="navbar" style="default" />
              <button id="nav-button" aria-label="Toggle Main Menu" aria-controls="primary-navigation" aria-expanded="false" onclick="toggleMenu();">
                <svg class="hamburger" viewBox="0 0 100 100" width="32">
                  <rect class="line top" width="80" height="10" x="10" y="20"></rect>
                  <rect class="line middle" width="80" height="10" x="10" y="45"></rect>
                  <rect class="line bottom" width="80" height="10" x="10" y="70"></rect>
                </svg>
              </button>
              <div class="menu-overlay" onclick="toggleMenu();"></div>
              <div id="primary-navigation" data-state="closed">
                <jdoc:include type="modules" name="navigation" style="default" />
              </div>
            </nav>
          </div>
        </header>
      <?php endif; ?>

      <main class="content-wrapper container-full">
        <?php if ($showAboveBody) : ?>
          <div class="abovebody <?= $aboveBodySize !== "container-full" ? "container-$aboveBodySize" : ""; ?>">
            <jdoc:include type="modules" name="above-body" style="default" />
          </div>
        <?php endif; ?>

        <div class="body-wrapper <?= $mainBodySize !== "container-full" ? "container-$mainBodySize" : ""; ?>">
          <?php if ($this->countModules('leftbody')) : ?>
            <?php if ($showLeftBody) : ?>
              <div class="leftbody">
                <jdoc:include type="modules" name="left-body" style="default" />
              </div>
            <?php endif; ?>
          <?php endif; ?>

          <div class="mainbody">
            <?php if ($showMainBodyTop) : ?>
              <jdoc:include type="modules" name="main-body-top" style="default" />
            <?php endif; ?>
            
            <jdoc:include type="message" />
            <jdoc:include type="component" />

            <?php if ($showMainBodyBottom) : ?>
              <jdoc:include type="modules" name="main-body-bottom" style="default" />
            <?php endif; ?>
          </div>

          <?php if ($this->countModules('right-body')) : ?>
            <?php if ($showRightBody) : ?>
              <div class="rightbody">
                <jdoc:include type="modules" name="right-body" style="default" />
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>

        <?php if ($showBelowBody) : ?>
          <div class="belowbody <?= $belowBodySize !== "container-full" ? "container-$belowBodySize" : ""; ?>">
            <jdoc:include type="modules" name="below-body" style="default" />
          </div>
        <?php endif; ?>
      </main>

      <?php if ($showFooter) : ?>
        <footer class="footer-wrapper container-full">
          <div class="footer <?= $footerSize !== "container-full" ? "container-$footerSize" : ""; ?>">
            <?php if ($showFooterLogo) : ?>
              <a
                class="footer-logo"
                href="<?= $this->baseurl; ?>"
              >
                <img
                  src="<?= $this->baseurl; ?>/<?= htmlspecialchars($footerLogo); ?>"
                  alt="<?= htmlspecialchars($sitetitle); ?>"
                />
              </a>
            <?php endif; ?>
            <jdoc:include type="modules" name="footer" style="default" />
            <?php if ($showCopyright) : ?>
              <hr />
              <small>
                <?php if ($copyrightText) : ?>
                  &copy;<?= date('Y'); ?> <?= htmlspecialchars($copyrightText); ?>
                <?php else : ?>
                  &copy;<?= date('Y'); ?> <?= htmlspecialchars($sitetitle); ?>
                <?php endif; ?>
              </small>
            <?php endif; ?>
          </div>
        </footer>
      <?php endif; ?>

      <jdoc:include type="modules" name="debug" style="default" />
    </div>

    <?php if ($codeBeforeBody) echo $codeBeforeBody; ?>
  </body>
</html>
