<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FieldOfWork;

class FieldOfWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            'Administrative Clerk', 'Budget Assistant', 'Treasury/Cashier Staff',
            'Civil Engineering Assistant', 'Project Monitoring Staff', 'Site Inspector',
            'IT Support Technician', 'Systems Developer Assistant', 'Web/Systems Administrator',
            'Barangay Health Worker Assistant', 'Medical Records Clerk', 'Social Welfare Assistant',
            'Traffic Enforcer Assistant', 'Emergency Response Staff', 'Inspection Officer Assistant',
            'Legal Research Assistant', 'Ordinance Drafting Assistant', 'Compliance Monitoring Staff',
            'Business Permit Assistant', 'Investment Promotion Assistant', 'MSME Support Staff',
            'Agricultural Technician Assistant', 'Environmental Monitoring Staff', 'Waste Management Assistant',
            'Daycare/Community Education Assistant', 'Scholarship Program Assistant', 'Community Development Worker'
        ];

        foreach ($fields as $field) {
            FieldOfWork::firstOrCreate(['name' => $field]);
        }
    }
}
