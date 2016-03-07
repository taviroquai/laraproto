<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);
        if (!DB::table('users')->count()) {
            DB::table('users')->insert([
                [
                    'name' => 'Admin',
                    'email' => 'admin@isp.com',
                    'password' => Hash::make('admin'),
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ]
            ]);
        }
        
        if (!DB::table('roles')->count()) {
            DB::table('roles')->insert([
                [
                    'name' => 'Admin',
                    'content_permission' => 'NONE',
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ],
                [
                    'name' => 'Backoffice User',
                    'content_permission' => 'ROLE',
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ],
                [
                    'name' => 'Registered',
                    'content_permission' => 'NONE',
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ]
            ]);
        }
        
        if (!DB::table('role_user')->count()) {
            DB::table('role_user')->insert([
                [
                    'role_id' => 1,
                    'user_id' => 1
                ]
            ]);
        }
        
        if (!DB::table('permissions')->count()) {
            DB::table('permissions')->insert([
                [
                    'label' => 'Backoffice',
                    'http' => 'GET',
                    'route' => 'admin',
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ],
                [
                    'label' => 'Pages List',
                    'http' => 'GET',
                    'route' => 'admin/pages/list',
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ],
                [
                    'label' => 'Users List',
                    'http' => 'GET',
                    'route' => 'admin/users/list',
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ],
                [
                    'label' => 'Roles List',
                    'http' => 'GET',
                    'route' => 'admin/roles/list',
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ],
                [
                    'label' => 'Permissions List',
                    'http' => 'GET',
                    'route' => 'admin/permissions/list',
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ],
                [
                    'label' => 'Site Brand',
                    'http' => 'GET',
                    'route' => 'admin/brands/list',
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ],
                [
                    'label' => 'Delete Content',
                    'http' => 'GET',
                    'route' => 'admin/contents/delete',
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ],
                [
                    'label' => 'Change Content Ownership',
                    'http' => 'GET',
                    'route' => 'admin/contents/ownership',
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ]
            ]);
        }
        
        if (!DB::table('permission_role')->count()) {
            DB::table('permission_role')->insert([
                [
                    'role_id' => 3,
                    'permission_id' => 1,
                    'access' => 'DENY'
                ],
                [
                    'role_id' => 2,
                    'permission_id' => 2,
                    'access' => 'DENY'
                ],
                [
                    'role_id' => 2,
                    'permission_id' => 3,
                    'access' => 'DENY'
                ],
                [
                    'role_id' => 2,
                    'permission_id' => 4,
                    'access' => 'DENY'
                ],
                [
                    'role_id' => 2,
                    'permission_id' => 5,
                    'access' => 'DENY'
                ],
                [
                    'role_id' => 2,
                    'permission_id' => 6,
                    'access' => 'DENY'
                ],
                [
                    'role_id' => 2,
                    'permission_id' => 7,
                    'access' => 'DENY'
                ],
                [
                    'role_id' => 2,
                    'permission_id' => 8,
                    'access' => 'DENY'
                ]
            ]);
        }
        
        if (!DB::table('brands')->count()) {
            DB::table('brands')->insert([
                [
                    'name' => 'Brand',
                    'slogan' => 'Brand slogan...',
                    'description' => 'Brand description',
                    'keywords' => 'keyword',
                    'author' => 'author',
                    'logo' => 'picture.png',
                    'active' => 1,
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ]
            ]);
        }
        
        if (!DB::table('contents')->count()) {
            DB::table('contents')->insert([
                [
                    'user_id' => 1,
                    'lang' => 'en',
                    'title' => 'Demo',
                    'seo_slug' => 'demo',
                    'seo_title' => 'Demo',
                    'seo_image' => 'picture.png',
                    'content' => '<p>Content...<br></p>',
                    'publish_start' => '2015-07-01',
                    'role_permission' => 'NONE',
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ]
            ]);
        }
        
        if (!DB::table('events')->count()) {
            DB::table('events')->insert([
                [
                    'content_id' => 1,
                    'start' => '2015-07-1',
                    'end' => '2015-07-2',
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ]
            ]);
        }
        
        if (!DB::table('locations')->count()) {
            DB::table('locations')->insert([
                [
                    'content_id' => 1,
                    'address' => 'Lisbon, Portugal',
                    'lat' => '38.7222524',
                    'lon' => '-9.139336599999979',
                    'zoom' => 5,
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ]
            ]);
        }
        
        if (!DB::table('pages')->count()) {
            DB::table('pages')->insert([
                [
                    'name' => 'demo_notfound',
                    'route' => 'page/notfound',
                    'active' => 1,
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ],
                [
                    'name' => 'demo_home',
                    'route' => '/',
                    'active' => 1,
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ],
                [
                    'name' => 'demo_content',
                    'route' => '{slug}',
                    'active' => 1,
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ],
                [
                    'name' => 'demo_events',
                    'route' => 'demo/events',
                    'active' => 1,
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ],
                [
                    'name' => 'demo_map',
                    'route' => 'demo/map',
                    'active' => 1,
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ]
            ]);
        }

        Model::reguard();
    }
}
