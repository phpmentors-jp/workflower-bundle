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

use PHPMentors\Workflower\Process\WorkflowContextInterface;

/**
 * @since Class available since Release 1.1.0
 */
class WorkflowContext implements WorkflowContextInterface
{
    /**
     * @var int|string
     */
    private $workflowContextId;

    /**
     * @var int|string
     */
    private $workflowId;

    /**
     * @param int|string $workflowContextId
     * @param int|string $workflowId
     */
    public function __construct($workflowContextId, $workflowId)
    {
        $this->workflowContextId = $workflowContextId;
        $this->workflowId = $workflowId;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkflowId()
    {
        return $this->workflowId;
    }

    /**
     * @return int|string
     */
    public function getWorkflowContextId()
    {
        return $this->workflowContextId;
    }
}
