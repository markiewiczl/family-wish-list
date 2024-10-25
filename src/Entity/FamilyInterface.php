<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

interface FamilyInterface
{
    public function getId(): ?int;

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection;

    public function addUser(User $user): static;

    public function removeUser(User $user): static;

    public function getName(): ?string;

    public function setName(string $name): static;
}