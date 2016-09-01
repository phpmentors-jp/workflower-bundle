<?php
/*
 * Copyright (c) KUBO Atsuhiro <kubo@iteman.jp>,
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

/**
 * @since Class available since Release 1.2.0
 */
class SecurityParticipantAwarePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('phpmentors_workflower.security_participant_aware') as $serviceId => $tagAttributes) {
            $class = new \ReflectionClass($container->getParameterBag()->resolveValue($container->getDefinition($serviceId)->getClass()));
            if (!$class->implementsInterface('PHPMentors\WorkflowerBundle\Workflow\Participant\SecurityParticipantAwareInterface')) {
                throw new \InvalidArgumentException(sprintf(
                    'The class "%s" must implement "%s".',
                    $class->getName(),
                    'PHPMentors\WorkflowerBundle\Workflow\Participant\SecurityParticipantAwareInterface'
                ));
            }

            for ($i = 0; $i < count($tagAttributes); ++$i) {
                $container->getDefinition($serviceId)->addMethodCall('setSecurityParticipant', array(new Reference('phpmentors_workflower.security_participant')));
            }
        }
    }
}
