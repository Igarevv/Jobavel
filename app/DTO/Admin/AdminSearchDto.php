<?php

declare(strict_types=1);

namespace App\DTO\Admin;

use App\Contracts\Admin\SearchEnumInterface;
use App\Traits\Searchable\SearchDtoInterface;

class AdminSearchDto implements SearchDtoInterface
{
    public function __construct(
        private SearchEnumInterface|string $searchBy,
        private ?string $searchable
    ) {
    }

    public function getSearchable(): ?string
    {
        return strtolower($this->searchable ?? '');
    }

    public function getSearchBy(): string|SearchEnumInterface
    {
        return $this->searchBy;
    }

    public function fromDto(): object
    {
        return (object)[
            'searchById' => is_string($this->searchBy) ? $this->searchBy : $this->searchBy->value,
            'searchByValue' => $this->searchBy->toString(),
            'search' => $this->searchable
        ];
    }

}
