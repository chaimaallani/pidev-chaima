<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivraisonRepository::class)
 */
class Livraison
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_h_l;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Personnel::class, inversedBy="livraisons")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $personnel;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="livraisons")
     */
    private $commandes;

    public function __construct()
    {
        $this->personnel = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHL(): ?\DateTimeInterface
    {
        return $this->date_h_l;
    }

    public function setDateHL(\DateTimeInterface $date_h_l): self
    {
        $this->date_h_l = $date_h_l;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->num_tel;
    }

    public function setNumTel(string $num_tel): self
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPersonnel(): ArrayCollection
    {
        return $this->personnel;
    }

    /**
     * @param ArrayCollection $personnel
     */
    public function setPersonnel(ArrayCollection $personnel): void
    {
        $this->personnel = $personnel;
    }



}
