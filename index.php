<?php

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

$app = Factory::getApplication();
$document = Factory::getDocument();
$user = Factory::getUser();

$timestamp = date('U');

$this->setHtml5(true);

// Get active menu item alias
$active = $app->getMenu()->getActive();

$params = $app->getTemplate(true)->params;

$logo = $this->params->get('logo', '');
$sitetitle = $this->params->get('sitetitle', $app->getCfg('sitename'));
$sitedescription = $this->params->get('sitedescription');

$nocacheheaders = $this->params->get('nocacheheaders');
$uncachecss = $this->params->get('uncachecss');
$uncachejs = $this->params->get('uncachejs');

$fontawesomecdn = $this->params->get('fontawesomecdn');

$googleSetup = $this->params->get('googleSetup');
$gtmcode = $this->params->get('gtmcode');
$gacode = $this->params->get('gacode');
$gagtmcode = $this->params->get('gagtmcode');
$fbcode = $this->params->get('fbcode');

$banner = $this->params->get('banner');
$topmenu = $this->params->get('topmenu');
$abovebody = $this->params->get('abovebody');
$leftbody = $this->params->get('leftbody');
$mainbodytop = $this->params->get('mainbodytop');
$mainbodybottom = $this->params->get('mainbodybottom');
$rightbody = $this->params->get('rightbody');
$belowbody = $this->params->get('belowbody');
$footer = $this->params->get('footer');
$alertbar = $this->params->get('alertbar');
$copyright = $this->params->get('copyright');
$copyrighttxt = $this->params->get('copyrighttxt');

$navTime = $this->params->get('navTime');
$containerNarrow = $this->params->get('containerNarrow');
$containerNormal = $this->params->get('containerNormal');
$containerWide = $this->params->get('containerWide');
$bannerContainer = $this->params->get('bannerSize');
$topmenuContainer = $this->params->get('topmenuSize');
$abovebodyContainer = $this->params->get('abovebodySize');
$mainbodyContainer = $this->params->get('mainbodySize');
$belowbodyContainer = $this->params->get('belowbodySize');
$footerContainer = $this->params->get('footerSize');

$killjoomlajs = $this->params->get('killjoomlajs');
$killjoomlacss = $this->params->get('killjoomlacss');
$instant = $this->params->get('instant');

$codeafterhead = $this->params->get('codeafterhead');
$codebeforehead = $this->params->get('codebeforehead');
$codeafterbody = $this->params->get('codeafterbody');
$codebeforebody = $this->params->get('codebeforebody');

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
    
    <?php unset($document->_scripts[JURI::root(true) . '/media/jui/js/jquery.min.js']); ?>

    <?php 
      if ($killjoomlajs == 1) {
        unset($document->_scripts[JURI::root(true) . '/media/system/js/caption.js']);
        unset($document->_scripts[JURI::root(true) . '/media/modal/js/script.min.js']);
        unset($document->_scripts[JURI::root(true) . '/media/system/js/core.js']);
        unset($document->_scripts[JURI::root(true) . '/media/jui/js/bootstrap.min.js']);
        if (isset($this->_script['text/javascript'])) {
          $this->_script['text/javascript'] = preg_replace('/jQuery\(window\).on\(\'load\'\,  function\(\) \{(.*);/is', '', $this->_script['text/javascript']);
          if (empty($this->_script['text/javascript'])) {
            unset($this->_script['text/javascript']);
          }
        }
      }
    ?>

    <?php 
      if ($killjoomlacss == 1) {
        unset($this->_stylesheets[JURI::root(true) . '/media/modals/css/bootstrap.min.css']);
        unset($this->_stylesheets[JURI::root(true) . '/media/jui/css/bootstrap.min.css']);
        unset($this->_stylesheets[JURI::root(true) . '/media/jui/css/bootstrap-responsive.min.css']);
        unset($this->_stylesheets[JURI::root(true) . '/media/jui/css/bootstrap-extended.css']);
      }
    ?>

    <?php $this->setGenerator(null); ?>

    <script>
      const newtralizeData = {
        nav_time: "<?= $navTime ?>"
      };
    </script>

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

    <?php if ($googleSetup === "gtm" && $gtmcode != null) : ?>
      <!-- Google Tag Manager -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','<?= $gtmcode; ?>');</script>
			<!-- End Google Tag Manager -->
    <?php endif; ?>

    <?php if (($googleSetup === "ga" || $googleSetup === "ga-gtm") && $gacode != null) : ?>
      <!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $gacode; ?>"></script>
			<script>
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());
				gtag('config', '<?= $gacode; ?>');
        <?php if ($googleSetup === "ga-gtm" && $gagtmcode != null) : ?>
          gtag('config', '<?= $gagtmcode; ?>');
        <?php endif; ?>
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
              <div id="primary-navigation" data-state="closed" style="--_nav-time: <?= $navTime ?>ms">
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
