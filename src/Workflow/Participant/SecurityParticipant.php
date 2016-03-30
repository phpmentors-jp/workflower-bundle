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

namespace PHPMentors\WorkflowerBundle\Workflow\Participant;

use PHPMentors\Workflower\Workflow\Participant\ParticipantInterface;
use PHPMentors\Workflower\Workflow\Resource\ResourceInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\Voter\RoleHierarchyVoter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityParticipant implements ParticipantInterface
{
    /**
     * @var RoleHierarchyVoter
     */
    private $roleHierarchyVoter;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var ResourceInterface
     */
    private $user;

    /**
     * @param RoleHierarchyVoter    $roleHierarchyVoter
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(RoleHierarchyVoter $roleHierarchyVoter, TokenStorageInterface $tokenStorage)
    {
        $this->roleHierarchyVoter = $roleHierarchyVoter;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole($role)
    {
        assert($this->tokenStorage->getToken() !== null);

        $result = $this->roleHierarchyVoter->vote($this->tokenStorage->getToken(), $this->getResource(), array($role));
        if ($result == VoterInterface::ACCESS_ABSTAIN) {
            throw new ParticipantException(sprintf('Checking whether the participant has role "%s" cannot be decided for some reason.', $role));
        }

        return $result == VoterInterface::ACCESS_GRANTED;
    }

    /**
     * {@inheritdoc}
     */
    public function setResource(ResourceInterface $resource)
    {
        assert($resource instanceof UserInterface);

        $this->user = $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
        return $this->user === null ? $this->tokenStorage->getToken()->getUser() : $this->user;
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
