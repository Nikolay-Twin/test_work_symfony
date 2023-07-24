<?php
declare(strict_types=1);
namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: \App\Domain\Repository\CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3)]
    private ?string $code = null;

    #[ORM\Column]
    private ?int $type = null;

    #[ORM\Column(nullable: true)]
    private ?bool $actual = true;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): static
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return $this
     */
    public function setType(int $type): static
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isActual(): ?bool
    {
        return $this->actual;
    }

    /**
     * @param bool|null $actual
     * @return $this
     */
    public function setActual(?bool $actual): static
    {
        $this->actual = $actual;
        return $this;
    }
}
