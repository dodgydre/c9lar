<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\Permission;
use App\Patient;
use App\Procedure;
use App\Insurer;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Zizaco\Entrust\HasRole;
use Zizaco\Entrust\EntrustRole;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Define some roles.
        $this->command->info('Start EntrustSeeder');

        $user1 = new User();
        $user1->name         = 'andreas';
        $user1->email = 'andreas@ohgeorgie.com';
        $user1->password  = Hash::make('password');
        $user1->save();

        $user2 = new User();
        $user2->name         = 'janice';
        $user2->email = 'janice@ohgeorgie.com';
        $user2->password  = Hash::make('password');
        $user2->save();

        $user3 = new User();
        $user3->name = 'michelle';
        $user3->email = 'michelle@ohgeorgie.com';
        $user3->password = Hash::make('password');
        $user3->save();

        // Define some roles.

        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'User Administrator'; // optional
        $admin->description  = 'User can do anything'; // optional
        $admin->save();

        $owner = new Role();
        $owner->name         = 'owner';
        $owner->display_name = 'Clinic Owner'; // optional
        $owner->description  = 'User is the owner of the clinic'; // optional
        $owner->save();

        $assistant = new Role();
        $assistant->name = 'assistant';
        $assistant->display_name = 'Assistant';
        $assistant->description = 'Assistant can access patient transactions but not employee details or patient notes';
        $assistant->save();

        // Assign an administrator role.
        $first_user = User::where('name', '=', 'andreas')->first();
        // role attach alias
        //$user->attachRole($admin); // parameter can be an Role object, array, or id
        // or eloquent's original technique
        $first_user->roles()->attach($admin->id); // id only

        $second_user = User::where('name', '=', 'janice')->first();
        $second_user->roles()->attach($owner->id);

        $third_user = User::where('name', '=', 'michelle')->first();
        $third_user->attachRole($assistant);

        // Attach some permissions

        $createEmployee = new Permission();
        $createEmployee->name         = 'create-employee';
        $createEmployee->display_name = 'Create Employee'; // optional
        // Allow a user to...
        $createEmployee->description  = 'create new employee'; // optional
        $createEmployee->save();

        $editPatient = new Permission();
        $editPatient->name         = 'edit-patient';
        $editPatient->display_name = 'Edit Patient'; // optional
        // Allow a user to...
        $editPatient->description  = 'edit existing patient'; // optional
        $editPatient->save();

        $admin->attachPermissions(array($createEmployee, $editPatient));
        // equivalent to $admin->perms()->sync(array($createPost->id));

        $owner->attachPermission($createEmployee);
        // equivalent to $owner->perms()->sync(array($createPost->id, $editUser->id));

        $this->command->info('End EntrustSeeder');

    }
}
