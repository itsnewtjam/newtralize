<?php

defined('_JEXEC') or die;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;

/** @var SiteApplication **/
$app = Factory::getApplication();
$document = $app->getDocument();

$timestamp = date('U');

$this->setHtml5(true);

// Get active menu item alias
$active = $app->getMenu()->getActive();

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
$uncacheHeads = $params->get('uncacheHeads', '0') === '1';

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
$containerNormal = $params->get('containerNormal', '64');
$containerNarrow = $params->get('containerNarrow', '40');
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

if ($nocacheheaders == 1) {
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
    
    <?php if ($codeafterhead != null) echo $codeafterhead; ?>

    <meta name="apple-mobile-web-app-capable" content="YES" />
    
    <?php $this->setGenerator(null); ?>

    <script src="<?= $this->baseurl; ?>/templates/<?= $this->template; ?>/js/template.js<?php if ($uncachejs == 1) echo "?v=$timestamp"; ?>"></script>
  
    <?php if (file_exists(JPATH_SITE . "/templates" . "/" . $this->template . "/js/custom.js")) : ?>
      <script src="<?= $this->baseurl; ?>/templates/<?= $this->template; ?>/js/custom.js<?php if ($uncachejs == 1) echo "?v=$timestamp"; ?>"></script>
    <?php endif; ?>

    <?php if (file_exists(JPATH_SITE . "/templates" . "/" . $this->template . "/js/menus/".$active->menutype.".js")) : ?>
      <script src="<?= $this->baseurl; ?>/templates/<?= $this->template; ?>/js/menus/<?= $active->menutype; ?>.js<?php if ($uncachejs == 1) echo "?v=$timestamp"; ?>"></script>
    <?php endif; ?>

    <?php if (file_exists(JPATH_SITE . "/templates" . "/" . $this->template . "/js/pages/".$active->alias.".js")) : ?>
      <script src="<?= $this->baseurl; ?>/templates/<?= $this->template; ?>/js/pages/<?= $active->alias; ?>.js<?php if ($uncachejs == 1) echo "?v=$timestamp"; ?>"></script>
    <?php endif; ?>

    <?php if ($gtmcode != null) : ?>
      <!-- Google Tag Manager -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','<?= $gtmcode; ?>');</script>
			<!-- End Google Tag Manager -->
    <?php endif; ?>

    <?php if ($gacode != null) : ?>
      <!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $gacode; ?>"></script>
			<script>
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());
				gtag('config', '<?= $gacode; ?>');
			</script>
      <?php 
        if (file_exists(JPATH_SITE."/"."templates/".$this->template."/"."heads/gaconversions/".$active->alias.".php")) {
          include(JPATH_SITE."/"."templates/".$this->template."/"."heads/gaconversions/".$active->alias.".php");
        }
      ?>
    <?php endif; ?>

    <?php if ($fbcode != null) : ?>
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
				fbq('init', '<?= $fbcode; ?>');
				fbq('track', 'PageView');
			</script>
			<noscript>
				<img height="1" width="1" style="display:none" 
						src="https://www.facebook.com/tr?id=<?= $fbcode; ?>&ev=PageView&noscript=1"/>
			</noscript>
			<!-- End Facebook Pixel Code -->
    <?php endif; ?>

    <style>
      :root {
        --container-narrow: <?= $containerNarrow ?>rem;
        --container-normal: <?= $containerNormal ?>rem;
        --container-wide: <?= $containerWide ?>rem;
      }
    </style>

    <link rel="stylesheet" href="<?= $this->baseurl; ?>/templates/<?= $this->template; ?>/css/template.css<?php if ($uncachecss == 1) echo "?v=$timestamp"; ?>" type="text/css">

    <?php if (file_exists(JPATH_SITE."/"."templates/".$this->template."/"."css/custom.css")): ?>
      <link rel="stylesheet" href="<?= $this->baseurl; ?>/templates/<?= $this->template; ?>/css/custom.css<?php if ($uncachecss == 1) echo "?v=$timestamp"; ?>" type="text/css">
    <?php endif; ?>

    <?php if (file_exists(JPATH_SITE."/"."templates/".$this->template."/"."css/menus/".$active->menutype.".css")): ?>
      <link rel="stylesheet" href="<?= $this->baseurl; ?>/templates/<?= $this->template; ?>/css/menus/<?= $active->menutype; ?>.css<?php if ($uncachecss == 1) echo "?v=$timestamp"; ?>" type="text/css">
    <?php endif; ?>
    
    <?php if (file_exists(JPATH_SITE."/"."templates/".$this->template."/"."css/pages/".$active->alias.".css")): ?>
      <link rel="stylesheet" href="<?= $this->baseurl; ?>/templates/<?= $this->template; ?>/css/pages/<?= $active->alias; ?>.css<?php if ($uncachecss == 1) echo "?v=$timestamp"; ?>" type="text/css">
    <?php endif; ?>

    <?php if ($fontawesomecdn != null) : ?>
      <script defer src="<?= $fontawesomecdn; ?>"></script>
    <?php endif; ?>

    <?php if ($codebeforehead != null) echo $codebeforehead; ?>
  </head>

  <body data-menu="<?= $active->menutype; ?>" data-page="<?= $active->alias; ?>">
    <?php if ($gtmcode != null) : ?>
      <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= $gtmcode; ?>"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
    <?php endif; ?>

    <?php if ($codeafterbody != null) echo $codeafterbody; ?>

    <div class="container">
      <?php if ($banner == 1) : ?>
        <div class="banner-wrapper">
          <div class="banner <?= $bannerContainer !== "full" ? "container-$bannerContainer" : ""; ?>">
            <jdoc:include type="modules" name="banner" style="default" />
          </div>
        </div>
      <?php endif; ?>

      <?php if ($topmenu == 1) : ?>
        <header class="navbar-wrapper">
          <div class="navbar <?= $topmenuContainer !== "full" ? "container-$topmenuContainer" : ""; ?>">
            <a
              class="logo"
              href="<?= $this->baseurl ?>"
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

      <main class="content-wrapper">
        <?php if ($abovebody == 1) : ?>
          <div class="abovebody <?= $abovebodyContainer !== "full" ? "container-$abovebodyContainer" : ""; ?>">
            <jdoc:include type="modules" name="above-body" style="default" />
          </div>
        <?php endif; ?>

        <div class="body-content <?= $mainbodyContainer !== "full" ? "container-$mainbodyContainer" : ""; ?>">
          <?php if ($this->countModules('leftbody')) : ?>
            <?php if ($leftbody == 1) : ?>
              <div class="leftbody">
                <jdoc:include type="modules" name="left-body" style="default" />
              </div>
            <?php endif; ?>
          <?php endif; ?>

          <div class="mainbody">
            <?php if ($mainbodytop == 1) : ?>
              <jdoc:include type="modules" name="main-body-top" style="default" />
            <?php endif; ?>
            
            <jdoc:include type="message" />
            <jdoc:include type="component" />

            <?php if ($mainbodybottom == 1) : ?>
              <jdoc:include type="modules" name="main-body-bottom" style="default" />
            <?php endif; ?>
          </div>

          <?php if ($this->countModules('right-body')) : ?>
            <?php if ($rightbody == 1) : ?>
              <div class="rightbody">
                <jdoc:include type="modules" name="right-body" style="default" />
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>

        <?php if ($belowbody == 1) : ?>
          <div class="belowbody <?= $belowbodyContainer !== "full" ? "container-$belowbodyContainer" : ""; ?>">
            <jdoc:include type="modules" name="below-body" style="default" />
          </div>
        <?php endif; ?>
      </main>

      <?php if ($footer == 1) : ?>
        <footer>
          <div class="footer-wrapper <?= $footerContainer !== "full" ? "container-$footerContainer" : ""; ?>">
            <jdoc:include type="modules" name="footer" style="default" />
            <?php if ($copyright == 1) : ?>
              <hr />
              <small>
                <?php if ($copyrighttxt != null) : ?>
                  &copy;<?= date('Y'); ?> <?= $copyrighttxt; ?>
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

    <?php if ($codebeforebody != null) echo $codebeforebody; ?>

    <?php if ($instant == 1) : ?>
      <script src="//instant.page/5.1.0" type="module" integrity="sha384-by67kQnR+pyfy8yWP4kPO12fHKRLHZPfEsiSXR8u2IKcTdxD805MGUXBzVPnkLHw"></script>
    <?php endif; ?>
  </body>
</html>
