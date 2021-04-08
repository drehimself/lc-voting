<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BizTools\Board;
use App\Models\BizTools\TaskBoard;
use App\Models\BizTools\LedgerCategory;
use App\Models\BizTools\SalesLeadsAndCustomer;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultGenericSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '-1');

        $boards = ['_new', '_converted', '_qualified', '_proposal_sent', '_contacted', '_disqualified'];
        $taskBoards = ['Favorites', 'ToDo', 'In Progress', 'Complete'];
        $classes = ['error', 'info', 'warning', 'success'];
        $categories = ['default', 'application_development', 'graphic_design'];
        $subscriptions = [];

        // $admin = User::create([
        //     'name'              => 'Admin',
        //     'email'             => 'admin@admin.com',
        //     'password'          => bcrypt('password'),
        //     'email_verified_at' => now(),
        //     'role_id'              => '0',
        // ]);

        foreach (range(0, 5) as $index) {
            $boardsInDB[] = Board::create([
                'title'    => ucfirst(str_replace('_', '', $boards[$index])),
                'short_id' => $boards[$index],
                'class'    => $classes[rand(0, 3)],
            ])->id;
        }

        $faker = Factory::create();

        foreach (range(1, 10) as $value) {
            SalesLeadsAndCustomer::create([
                'is_customer'    => false,
                'title'          => $faker->catchPhrase,
                'name'           => $faker->firstNameMale,
                'last_name'      => $faker->lastName,
                'board_id'       => $boardsInDB[rand(0, 5)],
                'category'       => $categories[rand(0, 2)],
                'telephone'      => $faker->phoneNumber,
                'email'          => $faker->safeEmail,
                'source'         => 'yellow_pages',
                'notes'          => json_encode('<b>foobar<b>'),
                'class'          => $classes[rand(0, 3)],
                'last_contacted' => now()->subDays(2),
            ]);
        }

        foreach (range(0, 3) as $index) {
            $taskBoardsInDB[] = TaskBoard::create([
                'name'  => ucfirst(str_replace('_', '', $taskBoards[$index])),
                'class' => $classes[rand(0, 3)],
            ])->id;
        }

        // foreach (range(1,10) as $value) {
        //     Task::create([
        //         'subject' => $faker->catchPhrase,
        //         'board_id' => $taskBoardsInDB[rand(0,3)],
        //         'status' => rand(1,3),
        //         'sort_order' => $value,
        //         'due_date' => now()->subDays(2),
        //     ]);
        // }

        foreach (range(1, 100) as $value) {
            $subscriptions[$value]['name'] = $faker->firstNameMale;
            $subscriptions[$value]['website_link'] = 'http://' . $faker->freeEmailDomain;
            $subscriptions[$value]['monthly_cost'] = rand(0, 10000);
            $subscriptions[$value]['created_at'] = now();
            $subscriptions[$value]['updated_at'] = now();
        }

        DB::table('subscriptions')->insert($subscriptions);

        $ledgerCategories = ['+ Sales', '- Advertising', '- Inventory', '- Shipping',
            '- Travel', '- Mileage', '+ Other', '- Other', '+/- Adjustment', ];
        foreach (range(0, 8) as $index) {
            LedgerCategory::create([
                'name' => $ledgerCategories[$index],
            ]);
        }
    }
}
