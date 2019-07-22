<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private $email;

    private $roles = [];

    private $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function __construct($payload)
    {
        $this->name = $payload['name'];
        $this->email = $payload['email'];
        
        if($payload['email'] === 'ferico.vandra17@student.uisi.ac.id'){
            $this->roles[] = 'ROLE_ADMIN';
        }
    }
}
