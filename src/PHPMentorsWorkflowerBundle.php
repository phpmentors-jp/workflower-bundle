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

namespace PHPMentors\WorkflowerBundle;

use PHPMentors\WorkflowerBundle\DependencyInjection\Compiler\AlterDefinitionsIntoProcessAwarePass;
use PHPMentors\WorkflowerBundle\DependencyInjection\PHPMentorsWorkflowerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PHPMentorsWorkflowerBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->loadFromExtension('jms_serializer', array(
            'metadata' => array(
                'directories' => array(
                    'phpmentors_workflower' => array(
                        'namespace_prefix' => 'PHPMentors\Workflower',
                        'path' => __DIR__.'/Resources/config/serializer/phpmentors/workflower',
                    ),
                    'piece_stagehand_fsm' => array(
                        'namespace_prefix' => 'Stagehand\FSM',
                        'path' => __DIR__.'/Resources/config/serializer/piece/stagehand-fsm',
                    ),
                ),
            ),
        ));
        $container->addCompilerPass(new AlterDefinitionsIntoProcessAwarePass());
    }

    /**
     * {@inheritDoc}
     */
    public function getContainerExtension()
    {
        if ($this->extension === null) {
            $this->extension = new PHPMentorsWorkflowerExtension();
        }

        return $this->extension;
    }
}
