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

namespace PHPMentors\WorkflowerBundle\Workflow\Participant;

use PHPMentors\Workflower\Workflow\Resource\ResourceInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @since Class available since Release 1.4.0
 */
class UserResource implements ResourceInterface
{
    /**
     * @var mixed
     */
    private $user;

    /**
     * @param mixed $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        if ($this->user instanceof UserInterface) {
            return $this->user->getUsername();
        } else {
            return (string) $this->user;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getId();
    }
}
