<?php

declare(strict_types=1);

namespace App\Contracts\Admin;

use App\Persistence\Models\Admin;
use Illuminate\Database\Eloquent\Model;

interface AdminActionDtoInterface
{
    public function getReasonForAction(): AdminReasonEnumInterface;

    public function getComment(): ?string;

    public function getAdmin(): Admin;

    public function getActionableModel(): Model;
}
