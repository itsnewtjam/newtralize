<?php

defined('_JEXEC') or die;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;
use Joomla\Database\DatabaseInterface;

/** @var SiteApplication **/
$app = Factory::getApplication();
$document = $app->getDocument();

define('NBASE', "/templates/" . $this->template);
define('NFILE', JPATH_BASE . NBASE);
define('NTIMESTAMP', date('U'));

$this->setHtml5(true);

// Get active menu item alias
$active = $app->getMenu()->getActive();

$activeCategory = null;
$activeArticle = null;
if ($active->query['option'] === "com_content" && $active->query['view'] === "article") {
  /** @var DatabaseInterface **/
  $db = Factory::getContainer()->get(DatabaseInterface::class);
  $query = $db->getQuery(true);
  $query
    ->select($db->quoteName(
      ['a.id', 'a.alias', 'b.id', 'b.alias'],
      ['articleId', 'articleAlias', 'categoryId', 'categoryAlias']
    ))
    ->from($db->quoteName('#__content', 'a'))
    ->join("INNER", $db->quoteName('#__categories', 'b') . " ON " . $db->quoteName('a.catid') . " = " . $db->quoteName('b.id'))
    ->where($db->quoteName('a.id') . " = " . $db->quote($active->query['id']));
  $db->setQuery($query);
  $articleData = $db->loadObject();
  $activeCategory = (object) [
    'id' => $articleData->categoryId,
    'alias' => $articleData->categoryAlias,
  ];
  $activeArticle = (object) [
    'id' => $articleData->articleId,
    'alias' => $articleData->articleAlias,
  ];
}

$n = $app->getTemplate(true)->params;

$sitetitle = $app->get('sitename');

$logo = $n->get('logo', '');
$showFooterLogo = $n->get('showfooterlogo', '1') === "1";
$differentFooterLogo = $n->get('differentfooterlogo', '1') === "1";
$footerLogo = $differentFooterLogo ? $n->get('footerlogo', '') : $logo;
$copyright = $n->get('copyright', '1') === "1";
$copyrighttxt = $n->get('copyrighttxt', '');

$nocacheheaders = $n->get('nocacheheaders', '0') === "1";
$uncachecss = $n->get('uncachecss', '0') === "1";
$uncachejs = $n->get('uncachejs', '0') === "1";

$scopeCategories = $n->get('scopecategories', 'alias') === "alias" ? $activeCategory->alias : $activeCategory->id;
$scopeArticles = $n->get('scopearticles', 'alias') === "alias" ? $activeArticle->alias : $activeArticle->id;
$scopePages = $n->get('scopepages', 'alias') === "alias" ? $active->alias : $active->id;

$fontawesomecdn = $n->get('fontawesomecdn', '');

$googleSetup = $n->get('googleSetup');
$gtmcode = $n->get('gtmcode');
$gacode = $n->get('gacode');
$gagtmcode = $n->get('gagtmcode');
$fbcode = $n->get('fbcode');

$banner = $n->get('banner') === "1";
$topmenu = $n->get('topmenu') === "1";
$abovebody = $n->get('abovebody') === "1";
$leftbody = $n->get('leftbody') === "1";
$mainbodytop = $n->get('mainbodytop') === "1";
$mainbodybottom = $n->get('mainbodybottom') === "1";
$rightbody = $n->get('rightbody') === "1";
$belowbody = $n->get('belowbody') === "1";
$footer = $n->get('footer') === "1";

$navTime = $n->get('navTime');
$containerNarrow = $n->get('containerNarrow');
$containerNormal = $n->get('containerNormal');
$containerWide = $n->get('containerWide');
$bannerContainer = $n->get('bannerSize');
$topmenuContainer = $n->get('topmenuSize');
$abovebodyContainer = $n->get('abovebodySize');
$mainbodyContainer = $n->get('mainbodySize');
$belowbodyContainer = $n->get('belowbodySize');
$footerContainer = $n->get('footerSize');

$codeafterhead = $n->get('codeafterhead');
$codebeforehead = $n->get('codebeforehead');
$codeafterbody = $n->get('codeafterbody');
$codebeforebody = $n->get('codebeforebody');

if ($nocacheheaders) {
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
}

function getNPath($path, $uncache) {
  $cachebust = "";
  if ($uncache) $cachebust = "?v=" . NTIMESTAMP;
  return NBASE . $path . $cachebust;
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

    <script>
      const newtralizeData = {
        nav_time: "<?= $navTime ?>"
      };
    </script>

    <script src="<?= getNPath("/js/template.js", $uncachejs); ?>"></script>
  
    <?php if (file_exists(NFILE . "/js/custom.js")) : ?>
      <script src="<?= getNPath("/js/custom.js", $uncachejs); ?>"></script>
    <?php endif; ?>

    <?php if (file_exists(NFILE . "/js/menus/$active->menutype.js")) : ?>
      <script src="<?= getNPath("/js/menus/$active->menutype.js", $uncachejs); ?>"></script>
    <?php endif; ?>

    <?php if (file_exists(NFILE . "/js/categories/$scopeCategories.js")) : ?>
      <script src="<?= getNPath("/js/categories/$scopeCategories.js", $uncachejs); ?>"></script>
    <?php endif; ?>

    <?php if (file_exists(NFILE . "/js/articles/$scopeArticles.js")) : ?>
      <script src="<?= getNPath("/js/articles/$scopeArticles.js", $uncachejs); ?>"></script>
    <?php endif; ?>

    <?php if (file_exists(NFILE . "/js/pages/$scopePages.js")) : ?>
      <script src="<?= getNPath("/js/pages/$scopePages.js", $uncachejs); ?>"></script>
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
        --container-narrow: <?= $containerNarrow; ?>rem;
        --container-normal: <?= $containerNormal; ?>rem;
        --container-wide: <?= $containerWide; ?>rem;
      }
    </style>

    <link rel="stylesheet" href="<?= getNPath("/css/template.css", $uncachecss); ?>" type="text/css">

    <?php if (file_exists(NFILE . "/css/custom.css")): ?>
      <link rel="stylesheet" href="<?= getNPath("/css/custom.css", $uncachecss); ?>" type="text/css">
    <?php endif; ?>

    <?php if (file_exists(NFILE . "/css/menus/$active->menutype.css")): ?>
      <link rel="stylesheet" href="<?= getNPath("/css/menus/$active->menutype.css", $uncachecss); ?>" type="text/css">
    <?php endif; ?>

    <?php if (file_exists(NFILE . "/css/categories/$scopeCategories.css")) : ?>
      <link rel="stylesheet" href="<?= getNPath("/css/categories/$scopeCategories.css", $uncachecss); ?>" type="text/css">
    <?php endif; ?>

    <?php if (file_exists(NFILE . "/css/articles/$scopeArticles.css")) : ?>
      <link rel="stylesheet" href="<?= getNPath("/css/articles/$scopeArticles.css", $uncachecss); ?>" type="text/css">
    <?php endif; ?>
    
    <?php if (file_exists(NFILE . "/css/pages/$scopePages.css")): ?>
      <link rel="stylesheet" href="<?= getNPath("/css/pages/$scopePages.css", $uncachecss); ?>" type="text/css">
    <?php endif; ?>

    <?php if ($fontawesomecdn != null) : ?>
      <script defer src="<?= $fontawesomecdn; ?>"></script>
    <?php endif; ?>

    <?php if ($codebeforehead != null) echo $codebeforehead; ?>

    <?php 
      if (file_exists(NFILE . "/heads/menus/$active->menutype.php")) {
        include(getNPath("/heads/menus/$active->menutype.php", false));
      }
    ?>
    
    <?php 
      if (file_exists(NFILE . "/heads/categories/$scopeCategories.php")) {
        include(getNPath("/heads/categories/$scopeCategories.php", false));
      }
    ?>
    
    <?php 
      if (file_exists(NFILE . "/heads/articles/$scopeArticles.php")) {
        include(getNPath("/heads/articles/$scopeArticles.php", false));
      }
    ?>
    
    <?php 
      if (file_exists(NFILE . "/heads/pages/$scopePages.php")) {
        include(getNPath("/heads/pages/$scopePages.php", false));
      }
    ?>
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
      <?php if ($banner) : ?>
        <div class="banner-wrapper">
          <div class="banner <?= $bannerContainer !== "full" ? "container-$bannerContainer" : ""; ?>">
            <jdoc:include type="modules" name="banner" style="default" />
          </div>
        </div>
      <?php endif; ?>

      <?php if ($topmenu) : ?>
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
        <?php if ($abovebody) : ?>
          <div class="abovebody <?= $abovebodyContainer !== "full" ? "container-$abovebodyContainer" : ""; ?>">
            <jdoc:include type="modules" name="above-body" style="default" />
          </div>
        <?php endif; ?>

        <div class="body-content <?= $mainbodyContainer !== "full" ? "container-$mainbodyContainer" : ""; ?>">
          <?php if ($this->countModules('leftbody')) : ?>
            <?php if ($leftbody) : ?>
              <div class="leftbody">
                <jdoc:include type="modules" name="left-body" style="default" />
              </div>
            <?php endif; ?>
          <?php endif; ?>

          <div class="mainbody">
            <?php if ($mainbodytop) : ?>
              <jdoc:include type="modules" name="main-body-top" style="default" />
            <?php endif; ?>
            
            <jdoc:include type="message" />
            <jdoc:include type="component" />

            <?php if ($mainbodybottom) : ?>
              <jdoc:include type="modules" name="main-body-bottom" style="default" />
            <?php endif; ?>
          </div>

          <?php if ($this->countModules('right-body')) : ?>
            <?php if ($rightbody) : ?>
              <div class="rightbody">
                <jdoc:include type="modules" name="right-body" style="default" />
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>

        <?php if ($belowbody) : ?>
          <div class="belowbody <?= $belowbodyContainer !== "full" ? "container-$belowbodyContainer" : ""; ?>">
            <jdoc:include type="modules" name="below-body" style="default" />
          </div>
        <?php endif; ?>
      </main>

      <?php if ($footer) : ?>
        <footer class="footer-wrapper">
          <div class="footer <?= $footerContainer !== "full" ? "container-$footerContainer" : ""; ?>">
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
            <?php if ($copyright) : ?>
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

  </body>
</html>
