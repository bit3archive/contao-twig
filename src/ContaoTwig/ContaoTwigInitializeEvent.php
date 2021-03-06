<?php

/**
 * Twig Integration for the Contao OpenSource CMS
 *
 * @package ContaoTwig
 * @link    https://github.com/bit3/contao-twig SCM
 * @link    http://de.contaowiki.org/Twig Wiki
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Class ContaoTwigInitializeEvent
 *
 * @package ContaoTwig
 * @author  Tristan Lins <tristan.lins@bit3.de>
 */
class ContaoTwigInitializeEvent extends \Symfony\Component\EventDispatcher\Event
{
	/**
	 * @var ContaoTwig
	 */
	protected $contaoTwig;

	function __construct(ContaoTwig $contaoTwig)
	{
		$this->contaoTwig = $contaoTwig;
	}

	/**
	 * @return \ContaoTwig
	 */
	public function getContaoTwig()
	{
		return $this->contaoTwig;
	}
}
