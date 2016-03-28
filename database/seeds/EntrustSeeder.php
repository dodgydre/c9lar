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

        // Define some roles.

        $owner = new Role();
        $owner->name         = 'owner';
        $owner->display_name = 'Project Owner'; // optional
        $owner->description  = 'User is the owner of a given project'; // optional
        $owner->save();

        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'User Administrator'; // optional
        $admin->description  = 'User is allowed to manage and edit other users'; // optional
        $admin->save();

        $subscriber = new Role();
        $subscriber->name = 'subscriber';
        $subscriber->display_name = 'Subscriber';
        $subscriber->description = 'Subscriber is allowed to view but not edit';
        $subscriber->save();

        // Assign an administrator role.
        $first_user = User::where('name', '=', 'andreas')->first();
        // role attach alias
        //$user->attachRole($admin); // parameter can be an Role object, array, or id
        // or eloquent's original technique
        $first_user->roles()->attach($admin->id); // id only

        $second_user = User::where('name', '=', 'janice')->first();
        $second_user->roles()->attach($subscriber->id);

        // Attach some permissions

        $createPost = new Permission();
        $createPost->name         = 'create-post';
        $createPost->display_name = 'Create Posts'; // optional
        // Allow a user to...
        $createPost->description  = 'create new blog posts'; // optional
        $createPost->save();

        $editUser = new Permission();
        $editUser->name         = 'edit-user';
        $editUser->display_name = 'Edit Users'; // optional
        // Allow a user to...
        $editUser->description  = 'edit existing users'; // optional
        $editUser->save();

        $admin->attachPermission($createPost);
        // equivalent to $admin->perms()->sync(array($createPost->id));

        $owner->attachPermissions(array($createPost, $editUser));
        // equivalent to $owner->perms()->sync(array($createPost->id, $editUser->id));

        $patient = new Patient;
        $patient->first_name = 'Andreas';
        $patient->last_name = 'Georghiou';
        $patient->modified_by = 1;
        $patient->created_by = 1;
        $patient->save();

        $procedure1 = new Procedure;
        $procedure1->code = 'CA';
        $procedure1->type = 'A';
        $procedure1->description = 'Chiropractic Adjustment';
        $procedure1->amount = 45;
        $procedure1->save();

        $procedure2 = new Procedure;
        $procedure2->code = 'RMT45';
        $procedure2->type = 'A';
        $procedure2->description = '45 Minute Massage';
        $procedure2->amount = 90;
        $procedure2->save();

        $insurer1 = new Insurer;
        $insurer1->code = 'BLU001';
        $insurer1->name = 'Blue Cross Medavie';
        $insurer1->save();


    }
}
