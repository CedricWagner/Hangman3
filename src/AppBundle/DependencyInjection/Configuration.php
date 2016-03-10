<?php

namespace AppBundle\DependencyInjection;

use  Symfony\Component\Config\Definition\ConfigurationInterface;
use  Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
* 
*/
class Configuration implements ConfigurationInterface
{
	
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder();
		$node = $treeBuilder->root('app');

		$node
			->children()
				->arrayNode('game')
					->children()
						->integerNode('word_length')
							->info('The word length of the game, or whatever')
							->defaultValue(8)
							->treatNullLike(8)
							->min(3)
							->max(10)
						->end()
						->arrayNode('dictionaries')
							->requiresAtLeastOneElement()
							->isRequired()
							->prototype('scalar')
								->validate()
									->ifTrue(function($value){
										return !is_readable($value);
									})
									->thenInvalid("The path %s is not readable")
								->end()
							->end()
						->end()
					->end()
				->end()
			->end();


		return $treeBuilder;
	}
}