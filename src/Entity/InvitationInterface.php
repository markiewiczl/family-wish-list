<?php

namespace App\Entity;

interface InvitationInterface
{
    public function getId(): ?int;

    public function getFamily(): ?Family;

    public function setFamily(Family $family): static;

    public function getToken(): ?string;

    public function setToken(string $token): static;

    public function getCreatedAt(): ?\DateTimeImmutable;

    public function setCreatedAt(\DateTimeImmutable $createdAt): static;
}