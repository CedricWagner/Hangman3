<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\VarDumper\VarDumper;

/**
* 
*/
class AppExtension extends Extension
{
	
	public function load(array $configs, ContainerBuilder $container){
		
		$config = $this->processConfiguration(new Configuration(),$configs);

		// VarDumper::dump($config);
		// die;

		$container->setParameter('app.game.dictionaries',$config['game']['dictionaries']);
		$container->setParameter('app.game.words_length',$config['game']['word_length']);
	}

}