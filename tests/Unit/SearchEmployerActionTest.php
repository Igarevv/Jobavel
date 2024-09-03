<?php

namespace Tests\Unit;

use App\Actions\Admin\Users\Employers\GetEmployersBySearchAction;
use App\Actions\Admin\Users\Employers\GetEmployersPaginatedAction;
use App\DTO\Admin\AdminSearchDto;
use App\Enums\Admin\AdminEmployersSearchEnum;
use App\Persistence\Models\Employer;
use App\Persistence\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class SearchEmployerActionTest extends TestCase
{
    use RefreshDatabase;

    private GetEmployersPaginatedAction $employersPaginatedAction;

    private GetEmployersBySearchAction $getEmployersBySearchAction;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employersPaginatedAction = $this->createMock(GetEmployersPaginatedAction::class);

        $this->getEmployersBySearchAction = new GetEmployersBySearchAction($this->employersPaginatedAction);
    }

    public function test_action_will_return_all_employers_if_search_string_is_empty(): void
    {
        $this->seed();

        $searchDto = $this->createMock(AdminSearchDto::class);

        $searchDto->method('getSearchByEnum')
            ->willReturn(AdminEmployersSearchEnum::COMPANY);

        $searchDto->method('getSearchable')
            ->willReturn('  ');

        $paginator = $this->createMock(LengthAwarePaginator::class);

        $this->employersPaginatedAction->method('handle')
            ->willReturn($paginator);

        $result = $this->getEmployersBySearchAction->handle($searchDto);

        $this->assertSame($paginator, $result);
    }

    public function test_action_return_same_as_passed_in_search_string(): void
    {
        User::factory()->has(
            Employer::factory()->state(
                function (array $attributes, User $user) {
                    return ['contact_email' => $user->email, 'company_name' => 'Apple Inc.'];
                }
            )
        )->create();

        $searchDto = $this->createMock(AdminSearchDto::class);

        $searchDto->method('getSearchByEnum')
            ->willReturn(AdminEmployersSearchEnum::COMPANY);

        $searchDto->method('getSearchable')
            ->willReturn('apple');

        $result = $this->getEmployersBySearchAction->handle($searchDto);

        $this->assertEquals('Apple Inc.', $result->first()?->company);
    }
}
