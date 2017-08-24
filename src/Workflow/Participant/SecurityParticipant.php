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

use PHPMentors\Workflower\Workflow\Participant\ParticipantInterface;
use PHPMentors\Workflower\Workflow\Resource\ResourceInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityParticipant implements ParticipantInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AccessDecisionManagerInterface
     *
     * @since Property available since Release 1.4.0
     */
    private $accessDecisionManager;

    /**
     * @var ResourceInterface
     */
    private $resource;

    /**
     * @param TokenStorageInterface          $tokenStorage
     * @param AccessDecisionManagerInterface $accessDecisionManager
     */
    public function __construct(TokenStorageInterface $tokenStorage, AccessDecisionManagerInterface $accessDecisionManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->accessDecisionManager = $accessDecisionManager;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole($role)
    {
        return $this->accessDecisionManager->decide($this->resource === null ? $this->tokenStorage->getToken() : ($this->resource instanceof UserInterface ? new UserToken($this->resource) : $this->resource), array($role));
    }

    /**
     * {@inheritdoc}
     */
    public function setResource(ResourceInterface $resource)
    {
        assert($resource instanceof UserInterface || $resource instanceof TokenInterface);

        $this->resource = $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
        if ($this->resource === null) {
            $token = $this->tokenStorage->getToken();
            if ($token === null) {
                return null;
            }

            $user = $token->getUser();
            if ($user instanceof ResourceInterface) {
                return $user;
            }

            return new UserResource($user);
        } else {
            return $this->resource;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getResource()->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getResource()->getName();
    }
}
