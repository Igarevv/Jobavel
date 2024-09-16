<?php

namespace App\Http\Controllers\Admin\Skills;

use App\Actions\Admin\Skills\GetSkillsNamePaginatedAction;
use App\DTO\Admin\AdminSearchDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminTechSkillRequest;
use App\Http\Resources\Admin\AdminTable;
use App\Persistence\Models\TechSkill;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSkillsController extends Controller
{
    public function index(): View
    {
        $this->authorize('view', TechSkill::class);

        return view('admin.skills');
    }

    public function fetchSkills(Request $request, GetSkillsNamePaginatedAction $action): AdminTable
    {
        $this->authorize('view', TechSkill::class);

        $skills = $action->handle(
            searchDto: new AdminSearchDto('skill_name', $request->get('search')),
            sortedValues: SortedValues::fromRequest($request->get('sort'), $request->get('direction'))
        );

        return new AdminTable($skills);
    }

    public function create(AdminTechSkillRequest $request): RedirectResponse
    {
        $skill = TechSkill::query()->create([
            'skill_name' => $request->get('skill')
        ]);

        return $skill->wasRecentlyCreated
            ? back()->with('created', trans('alerts.skills.created'))
            : back()->with('not-created', trans('alerts.skills.not-created'));
    }

    public function update(AdminTechSkillRequest $request, TechSkill $skill): RedirectResponse
    {
        $result = $skill->update(['skill_name' => $request->get('skill')]);

        return $result
            ? back()->with('update-success', trans('alerts.skills.update-success'))
            : back()->with('update-failed', trans('alerts.skills.update-failed'));
    }

    public function delete(Request $request, TechSkill $skill): RedirectResponse
    {
        $this->authorize('manage', TechSkill::class);

        $result = $skill->delete();

        return $result
            ? back()->with('delete-success', trans('alerts.skills.update-success'))
            : back()->with('delete-failed', trans('alerts.skills.update-failed'));
    }
}
