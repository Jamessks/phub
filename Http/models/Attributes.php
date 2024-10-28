<?php

namespace Http\models;

use Http\models\Stats;

class Attributes
{
    private ?string $hairColor = null;
    private ?string $ethnicity = null;
    private ?bool $tattoos = null;
    private ?bool $piercings = null;
    private ?int $breastSize = null;
    private ?string $breastType = null;
    private ?string $gender = null;
    private ?string $orientation = null;
    private ?int $age = null;
    private ?Stats $stats = null;

    public function __construct(array $data)
    {
        $this->hairColor = $data['hairColor'] ?? null;
        $this->ethnicity = $data['ethnicity'] ?? null;
        $this->tattoos = $data['tattoos'] ?? null;
        $this->piercings = $data['piercings'] ?? null;
        $this->breastSize = $data['breastSize'] ?? null;
        $this->breastType = $data['breastType'] ?? null;
        $this->gender = $data['gender'] ?? null;
        $this->orientation = $data['orientation'] ?? null;
        $this->age = $data['age'] ?? null;
        $this->stats = isset($data['stats']) ? new Stats($data['stats']) : null;
    }

    public function setHairColor(string $hairColor)
    {
        $this->hairColor = $hairColor;
    }

    public function setEthnicity(string $ethnicity)
    {
        $this->ethnicity = $ethnicity;
    }

    public function setTattoos(bool $tattoos)
    {
        $this->tattoos = $tattoos;
    }

    public function setPiercings(bool $piercings)
    {
        $this->piercings = $piercings;
    }

    public function setBreastSize(int $breastSize)
    {
        $this->breastSize = $breastSize;
    }

    public function setBreastType(string $breastType)
    {
        $this->breastType = $breastType;
    }

    public function setGender(string $gender)
    {
        $this->gender = $gender;
    }

    public function setOrientation(string $orientation)
    {
        $this->orientation = $orientation;
    }

    public function setAge(int $age)
    {
        $this->age = $age;
    }

    public function setStats(array $stats)
    {
        $this->stats = new Stats(['stats' => $stats]);
    }

    public function getHairColor(): ?string
    {
        return $this->hairColor;
    }

    public function getEthnicity(): ?string
    {
        return $this->ethnicity;
    }

    public function getTattoos(): ?int
    {
        return $this->tattoos;
    }

    public function getPiercings(): ?int
    {
        return $this->piercings;
    }

    public function getBreastSize(): ?int
    {
        return $this->breastSize;
    }

    public function getBreastType(): ?string
    {
        return $this->breastType;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function getStats(): ?Stats
    {
        return $this->stats;
    }
}
