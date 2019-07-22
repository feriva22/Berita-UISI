<?php
// api/src/Entity/Kategori.php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; // Symfony's built-in constraints


/**
 * Kategori berita
 *
 * @ApiResource
 * @ORM\Entity
 */
class Kategori
{
    /**
     * @var int Id dari  kategori ini.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @var string Nama dari kategori.
     * 
     ** @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 10,
     *      minMessage = "Nama kamu minimal {{ limit }} karakter",
     *      maxMessage = "Nama kamu kepanjangan"
     * )
     * @ORM\Column
     */
    public $nama;

    
    public function getId(): ?int
    {
        return $this->id;
    }
}