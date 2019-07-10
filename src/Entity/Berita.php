<?php
// api/src/Entity/Berita.php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * Berita.
 *
 * @ApiResource
 * @ORM\Entity
 */
class Berita
{
    /**
     * @var int id dari berita.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @var string nama berita
     *
     * @ORM\Column
     */
    public $judul;

    /**
     * @var string the body of the review.
     *
     * @ORM\Column(type="text")
     */
    public $isi;

    /**
     * @var string penulis berita ini
     *
     * @ORM\Column
     */
    public $penulis;

    /**
     * @var \DateTimeInterface Kapan berita ditulis
     *
     * @ORM\Column(type="datetime")
     */
    public $tanggal;

    /**
     * @var Kategori Kategori dari berita ini.
     *
     * @ORM\ManyToOne(targetEntity="Kategori", inversedBy="berita")
     */
    public $kategori;

    public function getId(): ?int
    {
        return $this->id;
    }
}