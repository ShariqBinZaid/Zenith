<?php declare(strict_types = 1);

namespace PHPStan\ExtensionInstaller;

/**
 * This class is generated by phpstan/extension-installer.
 * @internal
 */
final class GeneratedConfig
{

	public const EXTENSIONS = array (
  'composer/composer' => 
  array (
    'install_path' => 'C:\\xampp\\htdocs\\zenith\\vendor/composer/composer',
    'relative_install_path' => '../../../composer/composer',
    'extra' => 
    array (
      'includes' => 
      array (
        0 => 'phpstan/rules.neon',
      ),
    ),
    'version' => '2.4.4',
  ),
  'nesbot/carbon' => 
  array (
    'install_path' => 'C:\\xampp\\htdocs\\zenith\\vendor/nesbot/carbon',
    'relative_install_path' => '../../../nesbot/carbon',
    'extra' => 
    array (
      'includes' => 
      array (
        0 => 'extension.neon',
      ),
    ),
    'version' => '2.64.0',
  ),
  'nunomaduro/larastan' => 
  array (
    'install_path' => 'C:\\xampp\\htdocs\\zenith\\vendor/nunomaduro/larastan',
    'relative_install_path' => '../../../nunomaduro/larastan',
    'extra' => 
    array (
      'includes' => 
      array (
        0 => 'extension.neon',
      ),
    ),
    'version' => '1.0.4',
  ),
);

	public const NOT_INSTALLED = array (
);

	private function __construct()
	{
	}

}