<?php

namespace Http\models;

class Thumbnails
{
    private ?int $height;
    private ?int $width;
    private ?string $type;
    private ?array $urls;

    public function __construct(array $data)
    {
        $this->setHeight($data['height'] ?? null);
        $this->setWidth($data['width'] ?? null);
        $this->setType($data['type'] ?? null);
        $this->setUrls($data['urls'] ?? null);
    }

    public function setHeight(int $height)
    {
        $this->height = $height;
    }

    public function setWidth(int $width)
    {
        $this->width = $width;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function setUrls(array $urls)
    {
        foreach ($urls as $url) {
            $this->urls[] = $url;
        }
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getUrls(): ?string
    {
        if (!empty($this->urls)) {
            return Pornstar::extractImageFileName($this->urls[0]);
        }
        return null;
    }
}
