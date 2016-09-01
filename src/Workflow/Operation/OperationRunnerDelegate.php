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

/**
 * @since Class available since Release 1.2.0
 */
class OperationRunnerDelegate implements OperationRunnerInterface
{
    /**
     * @var array
     */
    private $operationRunners;

    /**
     * @param string                   $serviceId
     * @param OperationRunnerInterface $operationRunner
     */
    public function addOperationRunner($serviceId, OperationRunnerInterface $operationRunner)
    {
        $this->operationRunners[$serviceId] = $operationRunner;
    }

    /**
     * {@inheritdoc}
     *
     * @throws OperationRunnerNotFoundException
     */
    public function provideParticipant(OperationalInterface $operational, Workflow $workflow)
    {
        if (!array_key_exists($operational->getOperation(), $this->operationRunners)) {
            throw new OperationRunnerNotFoundException(sprintf('The operation runner for the operation "%s" is not found.', $operational->getOperation()));
        }

        return $this->operationRunners[$operational->getOperation()]->provideParticipant($operational, $workflow);
    }

    /**
     * {@inheritdoc}
     *
     * @throws OperationRunnerNotFoundException
     */
    public function run(OperationalInterface $operational, Workflow $workflow)
    {
        if (!array_key_exists($operational->getOperation(), $this->operationRunners)) {
            throw new OperationRunnerNotFoundException(sprintf('The operation runner for the operation "%s" is not found.', $operational->getOperation()));
        }

        $this->operationRunners[$operational->getOperation()]->run($operational, $workflow);
    }
}
