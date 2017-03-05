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

namespace PHPMentors\WorkflowerBundle\Process;

use PHPMentors\Workflower\Process\Process;

/**
 * @since Class available since Release 1.3.0
 */
class ProcessFactory
{
    /**
     * @var array
     */
    private $processes = array();

    /**
     * @param Process $process
     */
    public function addProcess(Process $process)
    {
        $workflowContext = $process->getWorkflowContext();
        assert($workflowContext instanceof WorkflowContext);

        $this->processes[$workflowContext->getWorkflowContextId()][$workflowContext->getWorkflowId()] = $process;
    }

    /**
     * @param int|string $workflowContextId
     * @param int|string $workflowId
     *
     * @return Process
     *
     * @throws \InvalidArgumentException
     */
    public function create($workflowContextId, $workflowId)
    {
        if (!array_key_exists($workflowContextId, $this->processes)) {
            throw new \InvalidArgumentException(sprintf('The workflow context "%s" is not found.', $workflowContextId));
        }

        if (!array_key_exists($workflowId, $this->processes[$workflowContextId])) {
            throw new \InvalidArgumentException(sprintf('The workflow "%s" is not found in the context "%s".', $workflowId, $workflowContextId));
        }

        return $this->processes[$workflowContextId][$workflowId];
    }
}
