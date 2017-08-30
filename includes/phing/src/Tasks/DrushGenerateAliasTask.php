<?php

namespace Phing\Ssk\Tasks;

use Project;
use Symfony\Component\Finder\Finder;

require_once 'phing/Task.php';

/**
 * A Phing task to generate an aliases.drushrc.php file.
 */
class DrushGenerateAliasTask extends \Task {

  /**
   * The name of the alias to generate.
   *
   * @var string
   */
  private $aliasName = '';

  /**
   * The uri of the alias to generate.
   *
   * @var string
   */
  private $aliasUri = '';

  /**
   * The root directory of the website.
   *
   * @var string
   */
  private $siteRoot = '';

  /**
   * The directory to save the aliases in.
   *
   * @var string
   */
  private $drushDir = '/sites/all/drush';

  /**
   * Generates an aliases.drushrc.php file.
   *
   * Either generates a file for:
   *  - all sites in the sites directory.
   *  - a single site to be added to the aliases file (appending).
   */
  public function main() {
    // Check if all required data is present.
    $this->checkRequirements();

    $drushDir = $this->drushDir == '/sites/all/drush' ? $this->siteRoot . $this->drushDir : $this->drushDir;
    $aliasesFile = $drushDir . '/aliases.drushrc.php';

    $aliases = array(
      'default' => array(
        'uri' => 'default',
        'root' => $this->siteRoot
      )
    );

    if (empty($this->aliasName)) {

      $sites = new Finder();
      $sites
        ->directories()
        ->depth('== 0')
        ->exclude('all')
        ->in($this->siteRoot . '/sites');

      foreach ($sites as $site) {
        $aliases[$site->getBasename()] = array(
          'uri' => $site->getBasename(),
          'root' => $aliases['default']['root'],
        );
      }
    }
    else {
      $aliases += $this->loadAliases($aliasesFile);
      $aliases[$this->aliasName] = array(
        'uri' => $this->aliasName,
        'root' => $aliases['default']['root'],
      );
    }

    $aliasesArray = "<?php \n\n\$aliases = " . var_export($aliases, true) . ";";

    if (file_put_contents($aliasesFile, $aliasesArray)) {
      $this->log("Succesfully wrote aliases to file '" . $aliasesFile . "'", Project::MSG_INFO);
    }
    else {
      $this->log("Was unable to write aliases to file '" . $aliasesFile . "'", Project::MSG_WARN);
    }
  }

  /**
   * Checks if all properties required for generating the aliases file are present.
   *
   * @throws \BuildException
   *   Thrown when a required property is not present.
   */
  protected function checkRequirements() {
    $required_properties = array('siteRoot');
    foreach ($required_properties as $required_property) {
      if (empty($this->$required_property)) {
        throw new \BuildException("Missing required property '$required_property'.");
      }
    }
  }

  protected function loadAliases($aliasesFile) {
    if (is_file($aliasesFile)) {
      return include $aliasesFile;
    }
    return array();
  }

  /**
   * Sets the name of the alias to set.
   *
   * @param string $aliasName
   *   The name of the alias to set.
   */
  public function setAliasName($aliasName) {
    $this->aliasName = $aliasName;
  }

  /**
   * Sets the uri of tha alias to set.
   *
   * @param string $aliasUri
   *   The uri of the alias to set.
   */
  public function setAliasUri($aliasUri) {
    $this->aliasUri = $aliasUri;
  }

  /**
   * Sets the root of the Drupal site.
   *
   * @param string $siteRoot
   *   The root of the Drupal site.
   */
  public function setSiteRoot($siteRoot) {
    $this->siteRoot = $siteRoot;
  }

  /**
   * Sets the diurectory of drush to place the aliases in.
   *
   * @param string $drushDir
   *   The Drush directory to place the aliases in
   *
   * @todo: validate if it is a registered location of drush.
   * @link: https://github.com/drush-ops/drush/blob/master/examples/example.aliases.drushrc.php#L57
   */
  public function setDrushDir($drushDir) {
    $this->drushDir = $drushDir;
  }
}