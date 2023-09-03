<?php

// Modules/Account/Database/Seeders/AccountDatabaseSeeder.php
// skip


// Modules/Account/Database/Seeders/YourSeeder.php
class YourSeeder extends Seeder
{
    public function __construct(private readonly AccountRepository $repository)
    {
    }

    public function run(): void
    {
        $this->repository->create([
            'name' => 'admin',
            'enable' => 1,
        ]);
    }
}

// phpunit 整合測試 test code
class Test extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('module:seed Account --class=AccountDatabaseSeeder');
        /*
        Account::factory()->create([
            'name' => 'Alice',
        ]);
        */
    }
}



