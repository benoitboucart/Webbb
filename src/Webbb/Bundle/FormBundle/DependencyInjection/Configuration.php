<?php

namespace Webbb\Bundle\FormBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('webbb_form');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
                ->arrayNode('field')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        /// The different form field types
                        ->arrayNode('field_types')
                            ->prototype('scalar')->end()
                            ->defaultValue(array(
                                'file'              => 'file-upload',
                                'number'            => 'number',
                                'phone'             => 'phone',
                                'url'               => 'url',
                                'choice'            => 'choice',
                                'text'              => 'text',
                            ))
                            ->info('The different field types of the form')
                        ->end()
                        // This will map a validation setting (inputted by the user) to a validation class
                        ->arrayNode('validation_types')
                            ->prototype('scalar')->end()
                            ->defaultValue(array(
                                'true'              => '\Symfony\Component\Validator\Constraints\True',
                                'false'             => '\Symfony\Component\Validator\Constraints\False',

                                'email'             => '\Symfony\Component\Validator\Constraints\Email',

                                'blank'             => '\Symfony\Component\Validator\Constraints\Blank',
                                'notblank'          => '\Symfony\Component\Validator\Constraints\NotBlank',

                                'null'              => '\Symfony\Component\Validator\Constraints\Null',
                                'notnull'           => '\Symfony\Component\Validator\Constraints\NotNull',
                                
                                'url'               => '\Symfony\Component\Validator\Constraints\Url',

                                'length'            => '\Symfony\Component\Validator\Constraints\Length', // max/min
                            ))
                            ->info('The different field types of the form')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        
        return $treeBuilder;
    }
}
