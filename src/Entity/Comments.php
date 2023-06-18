<?php

/**
 * This work, including the code samples, is licensed under a Creative Commons BY-SA 3.0 license.
 */

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=CommentsRepository::class)
 */
class Comments
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     *
     * @ORM\GeneratedValue
     *
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * E-mail.
     *
     * @ORM\Column(
     *     type="string",
     *     length=180,
     *     unique=true,
     * )
     *
     * @Assert\NotBlank
     *
     * @Assert\Email
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     *
     * @Assert\Length (
     *     min="1",
     *     max="64",
     * )
     */
    private ?string $nick;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Photos", fetch="EXTRA_LAZY")
     *
     * @ORM\JoinColumns({
     *
     *   @ORM\JoinColumn(name="photos_id", referencedColumnName="id")
     * })
     */
    private ?Photos $photos;

    /**
     * Get Id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get email.
     *
     * @return string|null Email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email Email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get Nickname.
     *
     * @return string|null Nick
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * Set Nickname.
     *
     * @param string $nick Nick
     *
     * @return $this Nick
     */
    public function setNick(string $nick): self
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * Get Text.
     *
     * @return string|null Text
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Set Text.
     *
     * @param string $text Text
     *
     * @return $this
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get Photos.
     *
     * @return Photos|null Photos
     */
    public function getPhotos(): ?Photos
    {
        return $this->photos;
    }

    /**
     * Set Photos.
     *
     * @param Photos|null $photos Photos
     *
     * @return $this Photos
     */
    public function setPhotos(?Photos $photos): self
    {
        $this->photos = $photos;

        return $this;
    }
}
