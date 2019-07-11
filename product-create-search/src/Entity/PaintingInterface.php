<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaintingRepository")
 */
interface PaintingInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(string $name): \App\Entity\Painting;

    public function getImageUrl(): ?string;

    public function setImageUrl(string $imageUrl): \App\Entity\Painting;

    public function getDescription(): ?string;

    public function setDescription(string $description): \App\Entity\Painting;

    public function getSize(): ?string;

    public function setSize(string $size): \App\Entity\Painting;

    public function getMedium(): ?string;

    public function setMedium(string $medium): \App\Entity\Painting;

    public function getCategory(): ?string;

    public function setCategory(string $category): \App\Entity\Painting;
}