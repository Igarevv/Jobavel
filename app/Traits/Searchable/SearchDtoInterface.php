<?php

namespace App\Traits\Searchable;

use App\Contracts\Admin\SearchEnumInterface;

interface SearchDtoInterface
{
    public function getSearchable(): ?string;

    public function getSearchByEnum(): SearchEnumInterface;
}