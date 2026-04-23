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
            [
                'name' => 'Public Administrative & Financial',
                'tooltip_content' => "- Administrative Clerk\n- Budget Assistant\n- Treasury/Cashier Staff"
            ],
            [
                'name' => 'Technical & Infrastructure',
                'tooltip_content' => "- Civil Engineering Assistant\n- Project Monitoring Staff\n- Site Inspector"
            ],
            [
                'name' => 'Information & Technology',
                'tooltip_content' => "- IT Support Technician\n- Systems Developer Assistant\n- Web/Systems Administrator"
            ],
            [
                'name' => 'Health & Social Services',
                'tooltip_content' => "- Barangay Health Worker Assistant\n- Medical Records Clerk\n- Social Welfare Assistant"
            ],
            [
                'name' => 'Public Safety & Regulation',
                'tooltip_content' => "- Traffic Enforcer Assistant\n- Emergency Response Staff\n- Inspection Officer Assistant"
            ],
            [
                'name' => 'Legal & Governance',
                'tooltip_content' => "- Legal Research Assistant\n- Ordinance Drafting Assistant\n- Compliance Monitoring Staff"
            ],
            [
                'name' => 'Business & Economic Development',
                'tooltip_content' => "- Business Permit Assistant\n- Investment Promotion Assistant\n- MSME Support Staff"
            ],
            [
                'name' => 'Environment & Agriculture',
                'tooltip_content' => "- Agricultural Technician Assistant\n- Environmental Monitoring Staff\n- Waste Management Assistant"
            ],
            [
                'name' => 'Education, Culture & Community',
                'tooltip_content' => "- Daycare/Community Education Assistant\n- Scholarship Program Assistant\n- Community Development Worker"
            ]
        ];

        // Clear existing fields first to avoid confusion with old data
        FieldOfWork::truncate();

        foreach ($fields as $field) {
            FieldOfWork::create($field);
        }
    }
}
