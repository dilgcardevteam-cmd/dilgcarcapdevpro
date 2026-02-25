<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = 'd:/Users/DILGCARPDMU-ISAIII/Downloads/regionv2.csv';

        if (!is_file($csvPath)) {
            throw new RuntimeException("CSV file not found at: {$csvPath}");
        }

        $handle = fopen($csvPath, 'r');
        if ($handle === false) {
            throw new RuntimeException("Unable to open CSV file: {$csvPath}");
        }

        $header = fgetcsv($handle);
        if (!is_array($header)) {
            fclose($handle);
            throw new RuntimeException('CSV header is missing or invalid.');
        }

        $normalizedHeader = array_map(
            static fn ($value) => strtolower(trim((string) $value)),
            $header
        );

        $codeIndex = array_search('region_code', $normalizedHeader, true);
        $nameIndex = array_search('region_name', $normalizedHeader, true);

        if ($codeIndex === false || $nameIndex === false) {
            fclose($handle);
            throw new RuntimeException('CSV must include region_code and region_name columns.');
        }

        $now = now();
        $rows = [];

        while (($data = fgetcsv($handle)) !== false) {
            $regionCode = trim((string) ($data[$codeIndex] ?? ''));
            $regionName = trim((string) ($data[$nameIndex] ?? ''));

            if ($regionCode === '' || $regionName === '') {
                continue;
            }

            $rows[] = [
                'region_code' => $regionCode,
                'region_name' => $regionName,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        fclose($handle);

        if ($rows === []) {
            $this->command?->warn('No valid rows found in region CSV.');
            return;
        }

        DB::table('regions')->upsert(
            $rows,
            ['region_code'],
            ['region_name', 'updated_at']
        );

        $this->command?->info('Region import completed: ' . count($rows) . ' row(s) processed.');
    }
}

