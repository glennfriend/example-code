// database/seeds/AdminUserSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * execute
 *      - php artisan db:seed --class=AdminUserSeeder
 */
class AdminUserSeeder extends Seeder
{
    private string $source;

    public function __construct()
    {
        $this->source = base_path() . '/database/seeds/sql/admin_user.sql';
    }

    public function run(): void
    {
        \DB::unprepared(file_get_contents($this->source));
    }
}
?>

- database/seeds/sql/admin_user.sql
```sql
-- user: admin2
-- password: admin2
INSERT INTO `users` (`id`, `parent_id`, `name`, `email`, `password`, `remember_token`, `kanban_id`, `kanban_password`, `status`) VALUES
  (1, 0, 'admin2', 'admin2@example.com', '$2y$10$UI8.1/pGfKhzgCSPDSuoqe6/uRHf1EYBaEMS5ZPEg0IYjFzlrpuIW', NULL, 0, '', 1);

-- model_id is users.id
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
  (1, 'App\Models\User', 1);

INSERT INTO `accounts` (`id`, `type`, `google_adwords_customer_id`, `name`, `sort`, `meta`) VALUES
(1, 'google', '111-111-1111', 'demo', 100, '{\"id\": 1111111111, \"name\": \"demo\", \"level\": 2, \"time_zone\": \"America/Los_Angeles\", \"is_manager\": false, \"currency_code\": \"USD\"}');

INSERT INTO `user_accounts` (`user_id`, `account_id`, `kanban_id`) VALUES
  (1, 1, 0);

```