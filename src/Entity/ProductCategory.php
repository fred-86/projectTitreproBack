<?php

namespace App\Entity;

use App\Repository\ProductCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductCategoryRepository::class)
 */
class ProductCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64 ,unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $pictogram;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=ProductCategory::class, inversedBy="childCategories")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=ProductCategory::class, mappedBy="parent")
     */
    private $childCategories;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="productCategories")
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity=Place::class, inversedBy="productCategories")
     */
    private $places;

  

    public function __construct()
    {
        $this->childCategories = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->places = new ArrayCollection();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPictogram(): ?string
    {
        return $this->pictogram;
    }

    public function setPictogram(?string $pictogram): self
    {
        $this->pictogram = $pictogram;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildCategories(): Collection
    {
        return $this->childCategories;
    }

    public function addChildCategory(self $childCategory): self
    {
        if (!$this->childCategories->contains($childCategory)) {
            $this->childCategories[] = $childCategory;
            $childCategory->setParent($this);
        }

        return $this;
    }

    public function removeChildCategory(self $childCategory): self
    {
        if ($this->childCategories->removeElement($childCategory)) {
            // set the owning side to null (unless already changed)
            if ($childCategory->getParent() === $this) {
                $childCategory->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addProductCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeProductCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection|Place[]
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): self
    {
        if (!$this->places->contains($place)) {
            $this->places[] = $place;
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        $this->places->removeElement($place);

        return $this;
    }

   
}