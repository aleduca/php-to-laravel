<?php

use Latte\Runtime as LR;

/** source: /var/www/html/resources/views/latte/home.latte */
final class Template_80f9f2e46b extends Latte\Runtime\Template
{
	public const Source = '/var/www/html/resources/views/latte/home.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h2>Home Latte</h2>

';
		echo LR\Filters::escapeHtmlText($name) /* line 3 */;
	}
}
