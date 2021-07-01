<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Photo
{
    /*
    * Timestampable trait
    */
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $archive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="integer")
     */
    private int $likes = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $private;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="photos")
     */
    private User $user;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private array $usersLiked = [];

    public function __construct($archive, $description, $private, $user) {
        $this->id = Uuid::v4()->toRfc4122();
        $this->archive = $archive;
        $this->description = $description;
        $this->private = $private;
        $this->user = $user;
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getArchive(): string
    {
        return $this->archive;
    }

    public function setArchive(string $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function addLike(): self
    {
        ++$this->likes;

        return $this;
    }

    public function removeLike(): self
    {
        --$this->likes;

        return $this;
    }

    public function getPrivate(): bool
    {
        return $this->private;
    }

    public function setPrivate(bool $private): self
    {
        $this->private = $private;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getUsersLiked(): array
    {
        return $this->usersLiked;
    }

    public function setUsersLiked(array $usersLiked): self
    {
        $this->usersLiked = $usersLiked;

        return $this;
    }

    public function addUsersLiked(string $user): void
    {
        if (in_array($user, $this->usersLiked, true)) {
            return;
        }
        $this->usersLiked[] = $user;
    }

    public function removeUsersLiked(string $user): void
    {
        if (($key = array_search($user, $this->usersLiked, true)) !== false) {
            unset($this->usersLiked[$key]);
        }
    }
}
