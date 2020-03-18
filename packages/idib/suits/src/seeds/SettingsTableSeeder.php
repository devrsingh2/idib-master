<?php

namespace Idib\Settings\Seeds;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Main Information (1-4)
        \DB::table('settings')->insert([
            'name' => 'info',
            'key' => 'name',
            'value' => 'سلعة'
        ]);
        \DB::table('settings')->insert([
            'name' => 'info',
            'key' => 'address',
            'value' => ''
        ]);
        \DB::table('settings')->insert([
            'name' => 'info',
            'key' => 'email',
            'value' => 'sel3a@sel3a.innocastle.com'
        ]);
        \DB::table('settings')->insert([
            'name' => 'info',
            'key' => 'phone',
            'value' => ''
        ]);
        // SMTP (5-12)
        \DB::table('settings')->insert([
            'name' => 'mail',
            'key' => 'driver',
            'value' => 'smtp'
        ]);
        \DB::table('settings')->insert([
            'name' => 'mail',
            'key' => 'host',
            'value' => 'sel3a.innocastle.com'
        ]);
        \DB::table('settings')->insert([
            'name' => 'mail',
            'key' => 'port',
            'value' => '465'
        ]);
        \DB::table('settings')->insert([
            'name' => 'mail',
            'key' => 'username',
            'value' => 'sel3a'
        ]);
        \DB::table('settings')->insert([
            'name' => 'mail',
            'key' => 'password',
            'value' => '*I&aW+b&[B[2'
        ]);
        \DB::table('settings')->insert([
            'name' => 'mail',
            'key' => 'address',
            'value' => 'sel3a@sel3a.innocastle.com'
        ]);
        \DB::table('settings')->insert([
            'name' => 'mail',
            'key' => 'name',
            'value' => 'Sel3a'
        ]);
        \DB::table('settings')->insert([
            'name' => 'mail',
            'key' => 'encryption',
            'value' => 'ssl'
        ]);
        // Social Accounts (13-16)
        \DB::table('settings')->insert([
            'name' => 'social_accounts',
            'key' => 'facebook',
            'value' => ''
        ]);
        \DB::table('settings')->insert([
            'name' => 'social_accounts',
            'key' => 'twitter',
            'value' => ''
        ]);
        \DB::table('settings')->insert([
            'name' => 'social_accounts',
            'key' => 'gplus',
            'value' => ''
        ]);
        \DB::table('settings')->insert([
            'name' => 'social_accounts',
            'key' => 'instagram',
            'value' => ''
        ]);
        // Mobile Applications Links (17-18)
        \DB::table('settings')->insert([
            'name' => 'app_links',
            'key' => 'apple',
            'value' => ''
        ]);
        \DB::table('settings')->insert([
            'name' => 'app_links',
            'key' => 'google',
            'value' => ''
        ]);
        // SEO (19-20)
        \DB::table('settings')->insert([
            'name' => 'seo',
            'key' => 'keywords',
            'value' => ''
        ]);
        \DB::table('settings')->insert([
            'name' => 'seo',
            'key' => 'description',
            'value' => ''
        ]);
        // SEO (21)
        \DB::table('settings')->insert([
            'name' => 'fcm',
            'key' => 'server_key',
            'value' => ''
        ]);
        // SEO (22-25)
        \DB::table('settings')->insert([
            'name' => 'sms',
            'key' => 'url',
            'value' => 'http://www.wesal.ws/api/get_api.php'
        ]);
        \DB::table('settings')->insert([
            'name' => 'sms',
            'key' => 'username',
            'value' => 'apple'
        ]);
        \DB::table('settings')->insert([
            'name' => 'sms',
            'key' => 'password',
            'value' => '123456'
        ]);
        \DB::table('settings')->insert([
            'name' => 'sms',
            'key' => 'sender',
            'value' => 'apple'
        ]);
        // Maintanance Mode Settings (26)
        \DB::table('settings')->insert([
            'name' => 'maintanance_mode',
            'key' => 'active',
            'value' => '0'
        ]);
        // Main Information (27-29)
        \DB::table('settings')->insert([
            'name' => 'bank_info',
            'key' => 'bank_name',
            'value' => 'البنك العربي'
        ]);
        \DB::table('settings')->insert([
            'name' => 'bank_info',
            'key' => 'bank_account_number',
            'value' => '5547778878'
        ]);
        \DB::table('settings')->insert([
            'name' => 'bank_info',
            'key' => 'bank_account_owner_name',
            'value' => ''
        ]);

        // Social Accounts ++
        \DB::table('settings')->insert([
            'name' => 'social_accounts',
            'key' => 'youtube',
            'value' => ''
        ]);
    }
}
