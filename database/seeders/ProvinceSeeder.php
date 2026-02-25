<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = 'd:/Users/DILGCARPDMU-ISAIII/Downloads/provinces.csv';

        if (!is_file($csvPath)) {
            throw new RuntimeException("CSV file not found at: {$csvPath}");
        }

        $regionMap = DB::table('regions')
            ->pluck('id', 'region_code')
            ->all();

        if ($regionMap === []) {
            throw new RuntimeException('No regions found. Seed regions table first.');
        }

        $rawCsv = file_get_contents($csvPath);
        if ($rawCsv === false) {
            throw new RuntimeException("Unable to read CSV file: {$csvPath}");
        }

        // Convert legacy ANSI/Windows-1252 files to UTF-8 for safe DB inserts.
        if (!mb_check_encoding($rawCsv, 'UTF-8')) {
            $rawCsv = mb_convert_encoding($rawCsv, 'UTF-8', 'Windows-1252');
        }

        // Normalize non-standard line endings (e.g., CR-only) so fgetcsv can parse rows correctly.
        $normalizedCsv = str_replace(["\r\n", "\r"], "\n", $rawCsv);

        $handle = fopen('php://temp', 'r+');
        if ($handle === false) {
            throw new RuntimeException('Unable to open temporary CSV stream.');
        }
        fwrite($handle, $normalizedCsv);
        rewind($handle);

        $header = fgetcsv($handle);
        if (!is_array($header)) {
            fclose($handle);
            throw new RuntimeException('CSV header is missing or invalid.');
        }

        $normalizedHeader = array_map(
            static fn ($value) => strtolower(trim((string) $value)),
            $header
        );
        // Handle UTF-8 BOM on first header cell.
        if (isset($normalizedHeader[0])) {
            $normalizedHeader[0] = ltrim($normalizedHeader[0], "\xEF\xBB\xBF");
        }

        $codeIndex = array_search('provinces_code', $normalizedHeader, true);
        $nameIndex = array_search('provinces', $normalizedHeader, true);

        if ($codeIndex === false || $nameIndex === false) {
            fclose($handle);
            throw new RuntimeException('CSV must include provinces_code and provinces columns.');
        }

        $now = now();
        $rows = [];
        $processed = 0;

        while (($data = fgetcsv($handle)) !== false) {
            $code = trim((string) ($data[$codeIndex] ?? ''));
            $name = trim((string) ($data[$nameIndex] ?? ''));

            if ($code === '' || $name === '' || strlen($code) !== 10) {
                continue;
            }

            // Province-identification rule from the request:
            // (3rd OR 4th OR 5th digit is non-zero) AND last 3 digits are 000.
            $thirdDigit = substr($code, 2, 1);
            $fourthDigit = substr($code, 3, 1);
            $fifthDigit = substr($code, 4, 1);
            $lastThreeDigits = substr($code, -3);

            $isProvinceByRule = ($thirdDigit !== '0' || $fourthDigit !== '0' || $fifthDigit !== '0')
                && $lastThreeDigits === '000';

            if (!$isProvinceByRule) {
                continue;
            }

            $regionCode = substr($code, 0, 2) . '00000000';
            $regionId = $regionMap[$regionCode] ?? null;

            if (!$regionId) {
                continue;
            }

            $rows[] = [
                'region_id' => $regionId,
                'province_code' => $code,
                'province_name' => $name,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $processed++;
        }

        fclose($handle);

        if ($rows === []) {
            $this->command?->warn('No province rows matched the rule.');
            return;
        }

        DB::table('provinces')->upsert(
            $rows,
            ['province_code'],
            ['region_id', 'province_name', 'updated_at']
        );

        $this->command?->info("Province import completed: {$processed} row(s) processed.");
    }
}
