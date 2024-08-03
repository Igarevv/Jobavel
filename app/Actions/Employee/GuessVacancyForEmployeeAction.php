<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Http\Presenters\VacancyCardPresenter;
use App\Persistence\Models\Vacancy;
use App\Service\Cache\Cache;
use App\Service\Employer\Vacancy\VacancyService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GuessVacancyForEmployeeAction
{

    public function __construct(
        private VacancyService $vacancyService,
        private Cache $cache
    ) {
    }

    public function handle(string $cacheKey, array $skills): Collection
    {
        $cacheKey = $this->cache->getCacheKey('related-vacancies-for-employee', $cacheKey);

        return $this->cache->repository()->remember(
            $cacheKey,
            Carbon::now()->addMinutes(30),
            function () use ($skills) {
                $vacancies = Vacancy::with(['employer:id,company_name,company_logo', 'techSkills:id,skill_name'])
                    ->select('id', 'title', 'location', 'employer_id')
                    ->published()
                    ->whereHas('techSkills', function (Builder $builder) use ($skills) {
                        $builder->whereIn('id', $skills);
                    }, '>=', '1')->take(4)->get();

                $vacancies = $this->vacancyService->overrideEmployerLogos($vacancies);

                return $vacancies->present(VacancyCardPresenter::class)->collectionToBase();
            }
        );
    }

}