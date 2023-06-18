<?php

/**
 * Galleries entity.
 */

namespace App\Entity;

use App\Repository\GalleriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Galleries.
 *
 * @ORM\Entity(repositoryClass=GalleriesRepository::class)
 *
 * @ORM\Table (name="Galleries")
 */
class Galleries
{
    /**
     * Primary key.
     *
     * @ORM\Id
     *
     * @ORM\GeneratedValue
     *
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * Created at.
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private ?\DateTimeInterface $createdAt;

    /**
     * Updated at.
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private ?\DateTimeInterface $updatedAt;

    /**
     * Title.
     *
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\Type(type="string")
     *
     * @Assert\NotBlank
     *
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private ?string $title;
    /**
     * Getter for Id.
     *
     * @var Collection Galleries
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Photos", mappedBy="gallery", fetch="EXTRA_LAZY", cascade={"remove"})
     */
    private Collection $photos;

    /**
     * Get Photos.
     *
     * @return Collection|null Photos
     */
    public function getPhotos(): ?Collection
    {
        return $this->photos;
    }

    /**
     * Code.
     *
     * @ORM\Column(
     *     type="string",
     *     length=64,
     * )
     *
     * @Assert\Type(type="string")
     *
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     *
     * @Gedmo\Slug(fields={"title"})
     */
    private ?string $code;

    /**
     * Galleries constructor.
     */
    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    /**
     * Get Id.
     *
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Created At.
     *
     * @return \DateTimeInterface|null Created at
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for Created at.
     *
     * @param \DateTimeInterface $createdAt Created at
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for Updated at.
     *
     * @return \DateTimeInterface|null Updated at
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Setter for Updated at.
     *
     * @param \DateTimeInterface $updatedAt Updated at
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Getter for Title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for Title.
     *
     * @param string|null $title Title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * Get Code.
     *
     * @return ?string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set Code.
     *
     * @param string $code Code
     *
     * @return $this Code
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
