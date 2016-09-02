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

namespace PHPMentors\WorkflowerBundle\Workflow\Operation;

use PHPMentors\Workflower\Workflow\Operation\OperationalInterface;
use PHPMentors\Workflower\Workflow\Operation\OperationRunnerInterface;
use PHPMentors\Workflower\Workflow\Workflow;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @since Class available since Release 1.2.0
 */
class OperationRunnerDelegate implements OperationRunnerInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function provideParticipant(OperationalInterface $operational, Workflow $workflow)
    {
        assert($this->container !== null);

        $operationRunner = $this->container->get($operational->getOperation());
        assert($operationRunner instanceof OperationRunnerInterface);

        return $operationRunner->provideParticipant($operational, $workflow);
    }

    /**
     * {@inheritdoc}
     */
    public function run(OperationalInterface $operational, Workflow $workflow)
    {
        assert($this->container !== null);

        $operationRunner = $this->container->get($operational->getOperation());
        assert($operationRunner instanceof OperationRunnerInterface);

        return $operationRunner->run($operational, $workflow);
    }
}
