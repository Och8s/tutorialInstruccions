<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Ifixit;

class IfixitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offset = 0;

        $endpoint = 'https://www.ifixit.com/api/2.0/guides?limit=200&offset=' . $offset;
        $response = Http::get($endpoint);
        while ($response->successful() && strlen(json_encode($response->json())) > 50) {
            if ($response->successful()) {
                $guides = $response->json();

                foreach ($guides as $guide) {
                    $prereq_modified_date = isset($guide['prereq_modified_date']) ? date('Y-m-d H:i:s', $guide['prereq_modified_date']) : null;

                    // Verificar y corregir el valor de prereq_modified_date
                    if ($prereq_modified_date === '1970-01-01 00:00:00') {
                        $prereq_modified_date = null;
                    }

                    Ifixit::updateOrInsert(
                        ['guide_id' => $guide['guideid']],
                        [
                            'data_type' => $guide['dataType'],
                            'locale' => $guide['locale'],
                            'revision_id' => $guide['revisionid'],
                            'modified_date' => date('Y-m-d H:i:s', $guide['modified_date']),
                            'prereq_modified_date' => $prereq_modified_date,
                            'url' => $guide['url'],
                            'type' => $guide['type'],
                            'category' => $guide['category'],
                            'subject' => $guide['subject'],
                            'title' => $guide['title'],
                            'summary' => $guide['summary'],
                            'difficulty' => $guide['difficulty'] ?? "",
                            'time_required_max' => $guide['time_required_max'] ?? null,
                            'public' => $guide['public'],
                            'user_id' => $guide['userid'],
                            'username' => $guide['username'],
                            'flags' => json_encode($guide['flags']),
                            'image' => json_encode($guide['image']),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
            $offset += 200;
            $endpoint = 'https://www.ifixit.com/api/2.0/guides?limit=200&offset=' . $offset;
            $response = Http::get($endpoint);
        }
    }
}
?>
