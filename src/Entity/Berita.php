<?php
// api/src/Entity/Berita.php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; // Symfony's built-in constraints
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Berita.
 *
 * @ApiResource(
 *     attributes={
 *          "access_control"="is_granted('ROLE_USER')",
 *          "order"={"tanggal": "DESC","id": "DESC"}
 *      },
 *     collectionOperations={
 *         "get"={"access_control"="is_granted('ROLE_USER')"},
 *         "post"={"access_control"="is_granted('ROLE_DOSEN') or is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
 *         "get"={"access_control"="is_granted('ROLE_USER')"},
 *         "put"={"access_control"="is_granted('ROLE_USER') and previous_object.penulis == user.name"},
 *         "delete"={"access_control"="is_granted('ROLE_USER')"},
 *     }
 * )
 * @ApiFilter(
 *      SearchFilter::class, 
 *      properties={
 *          "id": "exact", 
 *          "kategori": "exact", 
 *          "judul": "ipartial",
 *          "isi": "ipartial"
 *      }
 * )
 * @ApiFilter(
 *      OrderFilter::class, 
 *      properties={
 *          "id","judul","tanggal","kategori"
 *      }
 * )
 * 
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Berita
{
    /**
     * Hook SoftDeleteable behavior
     * updates deletedAt field
     */
    use SoftDeleteableEntity;

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
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Judul kamu minimal {{ limit }} karakter",
     *      maxMessage = "Judul kamu kepanjangan"
     * )
     * @ORM\Column
     * 
     */
    public $judul;

    /**
     * @var string isi berita.
     *
     * @Assert\NotBlank
     * @ORM\Column(type="text")
     */
    public $isi;

    /**
     * @var string penulis berita ini
     *
     * @ORM\Column
     * @Gedmo\Blameable(on="create")
     */
    private $penulis;

    /**
     * @var \DateTimeInterface Kapan berita ditulis
     *
     * @ORM\Column(type="datetime")
     */
    private $tanggal;

    /**
     * @var Kategori Kategori dari berita ini.
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="Kategori")
     */
    public $kategori;


    public function __construct()
    {
        $this->tanggal = new \DateTime("now");
    }

    public function getTanggal(): ?\DateTime
    {
        return $this->tanggal;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPenulis(): ?string
    {
        return $this->penulis;
    }

}