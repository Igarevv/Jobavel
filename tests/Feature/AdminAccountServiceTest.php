<?php

namespace Tests\Feature;

use App\DTO\Admin\AdminAccountDto;
use App\Persistence\Models\Admin;
use App\Service\Admin\AccountService;
use App\Service\Admin\FirstLoginService;
use Database\Seeders\AdminSeeder;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AdminAccountServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionSeeder::class, AdminSeeder::class]);
    }

    public function test_admin_account_info_update(): void
    {
        $admin = Admin::factory()->create();

        $firstLogin = Mockery::mock(FirstLoginService::class);

        $accountService = new AccountService($firstLogin);

        $accountDtoMock = Mockery::mock(AdminAccountDto::class);
        $accountDtoMock->shouldReceive('getFirstName')
            ->andReturn($admin->first_name);
        $accountDtoMock->shouldReceive('getLastName')
            ->andReturn('Doe');

        $accountService->updateName($admin, $accountDtoMock);
        $admin->refresh();

        $this->assertEquals('Doe', $admin->last_name);
    }
}
