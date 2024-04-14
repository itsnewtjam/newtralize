<?php

defined('_JEXEC') or die;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\Database\DatabaseInterface;

if (!isset($this->error)) {
  throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'), 404);
  $this->debug = false;
}

$isNotFound = $this->error->getCode() == "404";

$notFoundMenuItem = null;
$errorMenuItem = null;
if ($isNotFound) {
  /** @var DatabaseInterface **/
  $db = Factory::getContainer()->get(DatabaseInterface::class);
  $query = $db->getQuery(true);
  $query
    ->select($db->quoteName('id'))
    ->from($db->quoteName('#__menu'))
    ->where($db->quoteName('alias') . " = " . $db->quote('404'))
    ->where($db->quoteName('published') . " = " . $db->quote(1));
  $db->setQuery($query);
  $notFoundMenuItem = $db->loadResult();
} else {
  /** @var DatabaseInterface **/
  $db = Factory::getContainer()->get(DatabaseInterface::class);
  $query = $db->getQuery(true);
  $query
    ->select($db->quoteName('id'))
    ->from($db->quoteName('#__menu'))
    ->where($db->quoteName('alias') . " = " . $db->quote('error'))
    ->where($db->quoteName('published') . " = " . $db->quote(1));
  $db->setQuery($query);
  $errorMenuItem = $db->loadResult();
}
?>

<?php if (($isNotFound && $notFoundMenuItem) || $errorMenuItem) : ?>
  <?php
    /** @var SiteApplication **/
    $app = Factory::getApplication();
    http_response_code($this->error->getCode());
    try {
      $content = @file_get_contents(Uri::root() . ($isNotFound ? '404' : 'error'));
      if (!$content) throw new Exception();
      die; 
    } catch (Exception $e) {}
  ?>
<?php endif; ?>
<!DOCTYPE html>
<html lang="<?= $this->language; ?>" dir="<?= $this->direction; ?>">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="HandheldFriendly" content="true" />
    <meta name="apple-mobile-web-app-capable" content="YES" />
    <meta name="robots" content="noindex">
    <title><?= $this->error->getCode(); ?> - <?= $this->title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
  </head>
  <body class="error">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p class="text-center mt-5">
            <span style="font-size: 6em;" class="text-info"><i class="fas fa-search"></i></span>
          </p>
          <h1 class="text-center text-info">Oops. Nothing was found.</h1>

          <p class="text-center">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
          
          <p class="text-center"><a href="<?= $this->baseurl; ?>" title="Home Page">Go to the home page <i class="fas fa-external-link-alt"></i></a></p>
          
          <p class="text-center"><a href="javascript: history.go(-1)" title="Back to the previous page">Go back to the previous page <i class="fas fa-external-link-alt"></i></a></p>
            
          <p class="text-center">If problems continue, please contact the Website Administrator and report the error below.</p>
          
          <div class="tech-info">
          <p class="text-center text-muted">ERROR: <?= $this->error->getCode(); ?> - <?= $this->error->getMessage(); ?></p>
          <p class="text-center text-muted"><?= $this->error->getMessage(); ?></p>
          <p class="text-center text-muted">
            <?php if ($this->debug) echo $this->renderBacktrace(); ?>
          </p>
        </div>
      </div>
    </div>
  </body>
</html>
