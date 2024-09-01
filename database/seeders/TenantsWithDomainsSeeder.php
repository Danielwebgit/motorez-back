<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TenantsWithDomainsSeeder extends Seeder
{

  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $tenant = \App\Models\Tenant::create(['name' => 'Daniel', 'domain' => 'daniel.localhost']);
    $tenant->domains()->create(['domain' => 'daniel.localhost']);

    \App\Models\Tenant::where('id', $tenant->id)->get()->runForEach(function () {

      \App\Models\User::firstOrCreate(
        ['email' => 'daniel@gmail.com'],
        [
          'name' => 'Daniel',
          'email' => 'daniel@gmail.com',
          'password' => bcrypt('12345678'),
        ]
      );
    });

    $tenant = \App\Models\Tenant::create(['name' => 'Viviane', 'domain' => 'viviane.localhost']);
    $tenant->domains()->create(['domain' => 'viviane.localhost']);

    \App\Models\Tenant::where('id', $tenant->id)->get()->runForEach(function () {

      \App\Models\User::firstOrCreate(
        ['email' => 'viviane@gmail.com'],
        [
          'name' => 'Viviane',
          'email' => 'viviane@gmail.com',
          'password' => bcrypt('12345678'),
        ]
      );
    });
  }
}
