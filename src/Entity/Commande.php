<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_c;

    /**
     * @ORM\Column(type="date")
     */
    private $date_c;

    /**
     * @ORM\Column(type="float")
     */
    private $payement;

    /**
     * @ORM\ManyToOne(targetEntity=Livraison::class, inversedBy="Commandes")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $livraisons;

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateC(): ?\DateTimeInterface
    {
        return $this->date_c;
    }

    public function setDateC(\DateTimeInterface $date_c): self
    {
        $this->date_c = $date_c;

        return $this;
    }

    public function getPayement(): ?float
    {
        return $this->payement;
    }

    public function setPayement(float $payement): self
    {
        $this->payement = $payement;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumC()
    {
        return $this->num_c;
    }

    /**
     * @param mixed $num_c
     */
    public function setNumC($num_c): void
    {
        $this->num_c = $num_c;
    }

    public function somme ()  {

    }

}
