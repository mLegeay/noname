<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Personnage;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Anime
 *
 * @ORM\Table(name="anime")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnimeRepository")
 * @Vich\Uploadable
 */
class Anime
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="nomImage", type="string", length=255, nullable=true)
     */
    private $nomImage;


    /**
    * @ORM\Column(type="integer", nullable=true)
    *
    * @var integer
    */
    private $imageSize;

    /**
     * @Vich\UploadableField(mapping="anime_image", fileNameProperty="nomImage", size="imageSize")
     *
     * @var File
     */
     private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="Personnage", inversedBy="animes")
     * @ORM\JoinTable(name="anime_personnage")
     */
    private $personnages;

    public function __construct() {
        $this->personnages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addPersonnage(Personnage $personnage) {
        $this->personnages[] = $personnage;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Anime
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set urlImage
     *
     * @param string $urlImage
     *
     * @return Anime
     */
    public function setNomImage($nomImage)
    {
        $this->nomImage = $nomImage;

        return $this;
    }

    /**
     * Get urlImage
     *
     * @return string
     */
    public function getNomImage()
    {
        return $this->nomImage;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Anime
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setPersonnages($personnages)
    {
        $this->personnages = $personnages;
    }

    public function getPersonnages()
    {
        return $this->personnages;
    }
}
