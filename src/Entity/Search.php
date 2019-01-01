<?php

namespace App\Entity;


class Search
{
    /**
     * @var string|null
     */
    private $search;

    /**
     * @param string|null $search
     * @return Search
     */
    public function setSearch(string $search): Search
    {
        $this->search = $search;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

}