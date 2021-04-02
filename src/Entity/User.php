<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Cet email est déjà pris!")
 * @UniqueEntity(fields={"username"}, message="Ce pseudo est déjà pris!")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(
     *     groups="registration",
     *     message="Veuillez renseigner votre pseudo!"
     * )
     * @Assert\Length(
     *     groups="registration",
     *     min=3,
     *     max=50,
     *     minMessage="{{ limit }} caractères minimum svp!",
     *     maxMessage="{{ limit }} caractères maximum svp!"
     * )
     * @Assert\Regex(
     *     groups="registration",
     *     pattern="/^[\w]*$/",
     *     message="Seuls les caractères alphanumériques et _ sont acceptés!"
     * )
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\LessThan(
     *     groups="completeRegistration",
     *     value="-18 years",
     *     message="Il faut avoir au moins 18ans!"
     * )
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birth_date;

    /**
     * @Assert\NotBlank(
     *     groups="completeRegistration",
     *     message="Veuillez renseigner votre genre!"
     * )
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $gender;

    /**
     * @Assert\NotBlank(
     *     groups="completeRegistration",
     *     message="Veuillez renseigner votre code postal!"
     * )
     * @Assert\Regex(
     *     groups="completeRegistration",
     *     pattern="/^((0[1-9])|([1-8][0-9])|(9[0-8])|(2A)|(2B))[0-9]{3}$/",
     *     message="Veuillez renseigner un code postal français!"
     * )
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $zip_code;

    /**
     * @Assert\NotBlank(
     *     groups="completeRegistration",
     *     message="Veuillez renseigner la ville dans laquelle vous vivez!"
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @Assert\NotBlank(
     *     groups="registration",
     *     message="Veuillez renseigner votre email!"
     * )
     * @Assert\Length(
     *     groups="registration",
     *     min=6,
     *     max=250,
     *     minMessage="{{ limit }} caractères minimum svp!",
     *     maxMessage="{{ limit }} caractères maximum svp!"
     * )
     * @ORM\Column(type="string", length=250)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_updated;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has IS_AUTHENTICATED_ANONYMOUSLY
        $roles[] = 'IS_AUTHENTICATED_ANONYMOUSLY';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(?\DateTimeInterface $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(?string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->date_updated;
    }

    public function setDateUpdated(?\DateTimeInterface $date_updated): self
    {
        $this->date_updated = $date_updated;

        return $this;
    }
}
