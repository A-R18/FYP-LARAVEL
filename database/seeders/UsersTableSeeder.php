<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $patients = [];

        // Start transaction to ensure both users and patients are inserted correctly
        DB::beginTransaction();

        try {
            for ($i = 0; $i < 1000; $i++) {
                // Insert into users table and get the inserted user_id
                $userId = DB::table('users')->insertGetId([
                    'uname' => $faker->name,
                    'udob' => $faker->date('Y-m-d', '2005-12-31'),  // Random date of birth before 2005
                    'ucontact' => '03' . $faker->numerify('#########'),  // Pakistan number starting with 03 and 9 random digits
                    'gender' => $faker->randomElement(['male', 'female']),
                    'uemail' => $faker->unique()->safeEmail,
                    'upassword' => Hash::make('password'),  // Default password hashed
                    'role' => 'patient',
                    'remember_token' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Check if userId was generated correctly
                if (!$userId) {
                    throw new \Exception('User ID could not be generated');
                }

                // Add the patient's record to the `patients` table
                $patients[] = [
                    'users_id' => $userId,  // Foreign key reference to users table
                    'ptaddr' => $faker->address,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Bulk insert patients data
            DB::table('patients')->insert($patients);

            // Commit transaction
            DB::commit();
        } catch (\Exception $e) {
            // Rollback if any error occurs
            DB::rollBack();
            throw $e;
        }
    }
}
