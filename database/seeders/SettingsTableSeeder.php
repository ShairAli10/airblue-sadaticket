<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $apiData = [
                'ApiUrl' => 'https://api.havail.sabre.com',
                'UserId' => '9999',
                'Group' => Crypt::encrypt('LK6D'), // Encrypt the "Group" field
                'Domain' => 'AA',
                'Password' => Crypt::encrypt('asf84038'), // Encrypt the "Password" field
            ];
            Setting::updateOrCreate(
                ['id' => 1],
                [
                    'name' => 'sabre',
                    'type' => 'api',
                    'data' => $apiData, // Store the JSON data with encrypted fields
                    'status' => 1,
                ]
            );
            // ========================Email Setting==========================
            $smptData = [
                'MAILER' => 'smtp',
                'HOST' => 'smtp.sendgrid.net',
                'PORT' => '587',
                'USERNAME' => 'apikey',
                'PASSWORD' => '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', // Encrypt the "Password" field
                'ENCRYPTION' => 'tls', 
                'FROM_ADDRESS' => 'salesjp@jetpakistan.com', 
                'FROM_NAME' => 'JetPakistan.com', 
            ];
            Setting::updateOrCreate(
                ['id' => 3],
                [
                    'name' => 'sendgrid',
                    'type' => 'smtp',
                    'data' => $smptData,
                    'status' => 1,
                ]
            );
        } catch (\Exception $e) {
            
            // Log or dump the exception message for debugging.
            dd($e->getMessage());
        }
    }
}
