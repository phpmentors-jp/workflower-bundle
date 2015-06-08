<?php
/*
 * Copyright (c) 2015 KUBO Atsuhiro <kubo@iteman.jp>,
 * All rights reserved.
 *
 * This file is part of PHPMentorsWorkflowerBundle.
 *
 * This program and the accompanying materials are made available under
 * the terms of the BSD 2-Clause License which accompanies this
 * distribution, and is available at http://opensource.org/licenses/BSD-2-Clause
 */

namespace PHPMentors\WorkflowerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AlterDefinitionsIntoProcessAwarePass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     *
     * @throws \InvalidArgumentException
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('phpmentors_workflower.process_aware') as $serviceId => $tagAttributes) {
            $class = new \ReflectionClass($container->getParameterBag()->resolveValue($container->getDefinition($serviceId)->getClass()));
            if (!$class->implementsInterface('PHPMentors\Workflower\Process\ProcessAwareInterface')) {
                throw new \InvalidArgumentException(sprintf(
                    'The class "%s" must implement "%s".',
                    $class->getName(),
                    'PHPMentors\Workflower\Process\ProcessAwareInterface'
                ));
            }

            for ($i = 0; $i < count($tagAttributes); ++$i) {
                $this->validateTagAttribute($serviceId, 'phpmentors_workflower.process_aware', $tagAttributes[$i], 'context');
                $this->validateTagAttribute($serviceId, 'phpmentors_workflower.process_aware', $tagAttributes[$i], 'workflow');
                $container->getDefinition($serviceId)->addMethodCall('setProcess', array(new Reference('phpmentors_workflower.process.'.sha1($tagAttributes[$i]['context'].$tagAttributes[$i]['workflow']))));
            }
        }
    }

    /**
     * @param string $serviceId
     * @param string $tag
     * @param array  $attributes
     * @param string $attribute
     *
     * @throws \InvalidArgumentException
     */
    private function validateTagAttribute($serviceId, $tag, array $attributes, $attribute)
    {
        if (!array_key_exists($attribute, $attributes)) {
            throw new \InvalidArgumentException(sprintf(
                'The service "%s" must define the "%s" attribute on the "%s" tag.',
                $serviceId,
                $attribute,
                $tag
            ));
        }

        if ($attributes[$attribute] === null || $attributes[$attribute] === '') {
            throw new \InvalidArgumentException(sprintf(
                'The value of the "%s" attribute cannot be empty on the "%s" tag.',
                $attribute,
                $tag
            ));
        }
    }
}
