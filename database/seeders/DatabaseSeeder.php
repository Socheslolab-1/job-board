<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Sasha Socheslo',
            'email' => 'sasha@mail.com',
        ]);

        \App\Models\User::factory(300)->create();

        // Отримуємо всіх користувачів і перемішуємо їх у випадковому порядку
        $users = \App\Models\User::all()->shuffle();

        // Створюємо 20 роботодавців, використовуючи випадкового користувача для кожного
        for ($i = 0; $i < 20; $i++) {
            \App\Models\Employer::factory()->create([
            'user_id' => $users->pop()->id // Вибираємо останнього користувача зі списку (pop() забирає елемент)
    ]);
}

        // Отримуємо всіх роботодавців із бази даних
        $employers = \App\Models\Employer::all();

        // Створюємо 100 вакансій, прив'язуючи їх до випадкового роботодавця
            for ($i = 0; $i < 100; $i++) {
                \App\Models\Job::factory()->create([
                'employer_id' => $employers->random()->id // Вибираємо випадкового роботодавця
            ]);
        }

        foreach($users as $user) {
            $jobs = \App\Models\Job::inRandomOrder()->take(rand(0, 4))->get();

            foreach($jobs as $job) {
                \App\Models\JobApplication::factory()->create([
                    'job_id' => $job->id,
                    'user_id' => $user->id
                ]);
            }
        }

    }

}
