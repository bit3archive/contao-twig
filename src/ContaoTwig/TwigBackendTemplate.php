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
 * Class TwigBackendTemplate
 *
 * A BackendTemplate implementation that use Twig as template engine.
 *
 * @package ContaoTwig
 * @author  Tristan Lins <tristan.lins@bit3.de>
 */
class TwigBackendTemplate
	extends BackendTemplate
{
	public function __construct(
		$strTemplate = '',
		$strContentType = 'text/html'
	) {
		parent::__construct(
			$strTemplate,
			$strContentType
		);
	}

	/**
	 * @return string
	 */
	public function parse()
	{
		if ($this->strTemplate == '') {
			return '';
		}

		// Override the output format in the front end
		if (TL_MODE == 'FE') {
			global $objPage;

			if ($objPage->outputFormat != '') {
				$this->strFormat = $objPage->outputFormat;
			}

			$this->strTagEnding = ($this->strFormat == 'xhtml')
				? ' />'
				: '>';
		}

		// HOOK: add custom parse filters
		if (isset($GLOBALS['TL_HOOKS']['parseTemplate']) && is_array($GLOBALS['TL_HOOKS']['parseTemplate'])) {
			foreach ($GLOBALS['TL_HOOKS']['parseTemplate'] as $callback) {
				$this->import($callback[0]);
				$this->{$callback[0]}->{$callback[1]}($this);
			}
		}

		$strFile = $this->strTemplate . '.' . $this->strFormat . '.twig';
		$strBuffer = ContaoTwig::getInstance()
			->getEnvironment()
			->render(
			$strFile,
			$this->arrData
		);

		// HOOK: add custom parse filters
		if (isset($GLOBALS['TL_HOOKS']['parseBackendTemplate']) && is_array(
			$GLOBALS['TL_HOOKS']['parseBackendTemplate']
		)
		) {
			foreach ($GLOBALS['TL_HOOKS']['parseBackendTemplate'] as $callback) {
				$this->import($callback[0]);
				$strBuffer = $this->{$callback[0]}->{$callback[1]}(
					$strBuffer,
					$this->strTemplate
				);
			}
		}

		return $strBuffer;
	}
}
