<?php

namespace Mika\TrackerMvc\Model\Entity;

class Item
{
    private int $id;
    private string $title;
    private Projet $projet;
    private string $timestamp;

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     * @return self
     */
    public function setTimestamp(string $timestamp): self
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return Projet
     */
    public function getProjet(): Projet
    {
        return $this->projet;
    }

    /**
     * @param Projet $projet
     * @return self
     */
    public function setProjet(Projet $projet): self
    {
        $this->projet = $projet;
        return $this;
    }



}