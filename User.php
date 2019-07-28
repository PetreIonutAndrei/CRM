<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User {
    /**
     * @var int 
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $userId;
    /**
     * @var string
     * @ORM\Column(type="string", length=64) 
     */
    private $email;
    /**
     * @var string 
     * @ORM\Column(type="string", length=110)
     */
    private $hashedPassword;
    /**
     * @var string 
     * @ORM\Column(type="string", length=110)
     */
    private $role;
    /**
     * @param string $email
     * @param string $password
     * @param string $role
     */
    public function __construct(
            string $email, string $password, string $role
    ) {
        $this->email = $email;
        $this->setPassword($password);
        $this->role = $role;
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPassword(string $password) {
        $this->hashedPassword = password_hash(
                $password, PASSWORD_DEFAULT
        );
    }
     /**
     * @param string $email
     * @return void
     */
    function setEmail($email) {
        $this->email = $email;
    }
    /**
     * @param string $hashedPassword
     * @return void
     */
    function setHashedPassword($hashedPassword) {
        $this->hashedPassword = $hashedPassword;
    }
    /**
     * @param string $role
     * @return void
     */
    function setRole($role) {
        $this->role = $role;
    }

    public function hasPassword(string $password): bool {
        return password_verify($password, $this->hashedPassword);
    }
    
    public function getUserId(): int {
        return $this->userId;
    }
    function getEmail() {
        return $this->email;
    }

    function getHashedPassword() {
        return $this->hashedPassword;
    }

    function getRole() {
        return $this->role;
    }

    


}
