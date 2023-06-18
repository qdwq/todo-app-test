<?php

/**
 * Photos entity.
 */

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Photos.
 *
 * @ORM\Entity(repositoryClass=PhotosRepository::class)
 *
 * @ORM\Table(name="Photos")
 */
class Photos
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
     * @Gedmo\Timestampable(on="create")
     */
    private \DateTimeInterface $createdAt;

    /**
     * Updated at.
     *
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private ?\DateTimeInterface $updatedAt;

    /**
     * Title.
     *
     * @ORM\Column(type="string", length=64)
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
     * Text.
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank
     *
     * @Assert\Length(
     *     min="3",
     *     max="255",
     * )
     */
    private ?string $text;

    /**
     * Filename.
     *
     * @ORM\Column(
     *     type="string",
     *     length=191,
     * )
     *
     * @Assert\Type(type="string")
     */
    private ?string $filename;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Galleries", inversedBy="photos", fetch="EXTRA_LAZY")
     *
     * @ORM\JoinColumns({
     *
     *   @ORM\JoinColumn(name="gallery_id", referencedColumnName="id")
     * })
     */
    private ?Galleries $gallery;

    /**
     * Photos constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Getter for Id.
     *
     * @return int|null Result
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
     * @param string $title Title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter for Text.
     *
     * @return string|null Text
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Setter for Text.
     *
     * @param string|null $text Text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    /**
     * Getter for the Galleries.
     *
     * @return Galleries|null Galleries
     */
    public function getGalleries(): ?Galleries
    {
        return $this->gallery;
    }

    /**
     * Setter for the Galleries.
     *
     * @param Galleries|null $gallery Galleries
     *
     * @return void Galleries
     */
    public function setGalleries(?Galleries $gallery): void
    {
        $this->gallery = $gallery;
    }

    /**
     * Getter for the Filename.
     *
     * @return string Filename
     */
    public function getFilename(): string
    {
        return (string) $this->filename;
    }

    /**
     * Setter for the Filename.
     *
     * @param string $filename Filename
     *
     * @return void Filename
     */
    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }
}
