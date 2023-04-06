<?php

namespace App\Model\User;

class UserFilter
{

    private ?int $page = 1;
    private ?int $limit = 10;
    private ?bool $sortByNick = false;
    private ?string $sortDirection = 'ASC';

    public function getPage(): ?int
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage(?int $page): void
    {
        $this->page = $page;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    public function getSortByNick(): ?bool
    {
        return $this->sortByNick;
    }


    public function setSortByNick(?bool $sortByNick): void
    {
        $this->sortByNick = $sortByNick;
    }

    public function getSortDirection(): ?string
    {
        return $this->sortDirection;
    }

    public function setSortDirection(?string $sortDirection): void
    {
        $this->sortDirection = $sortDirection;
    }

}