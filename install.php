<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\Database\DatabaseInterface;

class newtralizeInstallerScript {
  private $previousVersion = '';  

	public function __construct(InstallerAdapter $adapter) {
	}
	
	public function preflight($route, InstallerAdapter $adapter) {
    /** @var DatabaseInterface **/
    $db = Factory::getContainer()->get(DatabaseInterface::class);
    $query = $db->getQuery(true);
    $query
      ->select($db->quoteName('manifest_cache'))
      ->from($db->quoteName('#__extensions'))
      ->where($db->quoteName('element') . " = " . $db->quote('newtralize'));
    $db->setQuery($query);
    $manifestCache = json_decode($db->loadResult());
    $this->previousVersion = $manifestCache->version;
		return true;
	}
	
	public function postflight($route, $adapter) {
		if (strtoupper($route) == "UPDATE") {
      $changelog = $this->buildChangelog();

			Factory::getApplication()->enqueueMessage(
				'<h2 style="font-size: 1.25em; font-weight: 700">Updated newtralize to version ' 
				. $adapter->getManifest()->version 
				. '.</h2>'
				. $changelog, 'notice'
			);
		}
		return true;
	}
	
	public function install(InstallerAdapter $adapter) {
		return true;
	}
	
	public function update(InstallerAdapter $adapter) {
		return true;
	}

	public function uninstall(InstallerAdapter $adapter) {
		return true;
	}

  private function buildChangelog() {
    $changelogFile = file_get_contents(dirname(__FILE__) . '/changelog.txt');

    $entries = explode("\n\n", $changelogFile);
    
    $changelog = [];
    $changelog[] = array_shift($entries);

    if ($this->previousVersion) {
      foreach ($entries as $entry) {
        preg_match('/v(\d+\.\d+\.\d+) \((\d{4}-\d{2}-\d{2})\)/', $entry, $matches);
        $entryVersion = $matches[1];
        if (!$this->isNewerVersion($entryVersion, $this->previousVersion)) break;
        $changelog[] = $entry;
      }
    }

    $badges = [
      "\[Added\]" => '<span class="badge bg-success text-white"><i class="fa fa-plus-circle"></i> Added</span>',
      "\[Changed\]" => '<span class="badge bg-info text-white"><i class="fa fa-cogs"></i> Changed</span>',
      "\[Deprecated\]" => '<span class="badge bg-warning text-white"><i class="fa fa-clock"></i> Deprecated</span>',
      "\[Fixed\]" => '<span class="badge bg-info text-white"><i class="fa fa-bug"></i> Fixed</span>',
      "\[Removed\]" => '<span class="badge bg-danger text-white"><i class="fa fa-trash"></i> Removed</span>',
      "\[Security\]" => '<span class="badge bg-danger text-white"><i class="fa fa-shield-alt"></i> Security</span>',
    ];

    $changelogOutput = [];
    foreach ($changelog as $version) {
      $version = htmlspecialchars($version);
      foreach ($badges as $marker => $badge) {
        $version = preg_replace("/$marker/", $badge, $version);
      }
      $changelogOutput[] = $version;
    }

    $output = ''; 
    foreach ($changelogOutput as $version) {
      $output .= '<pre class="border bg-light p-2" style="line-height: 1.75em;">' . $version . '</pre>';
    }

    return $output;
  }

  private function isNewerVersion($compare, $against) {
    $compareSplit = preg_split("/\./", $compare);
    $compareMajor = $compareSplit[0];
    $compareMinor = $compareSplit[1];
    $comparePatch = $compareSplit[2];
    $againstSplit = preg_split("/\./", $against);
    $againstMajor = $againstSplit[0];
    $againstMinor = $againstSplit[1];
    $againstPatch = $againstSplit[2];

    if ($compareMajor >= $againstMajor) {
      if ($compareMinor >= $againstMinor) {
        if ($comparePatch > $againstPatch) {
          return true;
        }
      }
    }

    return false;
  }
}

?>
