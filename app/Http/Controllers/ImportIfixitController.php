<?php

namespace App\Http\Controllers;

use App\Models\Ifixit;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ImportIfixitController extends Controller
{
    public function __invoke(Request $request)
    {
        $ifitxit = Ifixit::whereNotIN('guide_id', Guide::select('guide_id')->get())->first();

        $endpoint = 'https://www.ifixit.com/api/2.0/guides/' . $ifitxit->guide_id;
        $response = Http::get($endpoint);

        if ($response->successful()) {
            $guideData = $response->json();

            DB::table('guides')->updateOrInsert(
                ['guide_id' => $guideData['guideid']],
                [
                    'title' => $guideData['title'],
                    'category' => $guideData['category'],
                    'subject' => $guideData['subject'],
                    'summary' => $guideData['summary'],
                    'introduction_raw' => $guideData['introduction_raw'],
                    'introduction_rendered' => $guideData['introduction_rendered'],
                    'conclusion_raw' => $guideData['conclusion_raw'],
                    'conclusion_rendered' => $guideData['conclusion_rendered'],
                    'difficulty' => $guideData['difficulty'],
                    'time_required_min' => $guideData['time_required_min'] ?? null,
                    'time_required_max' => $guideData['time_required_max'] ?? null,
                    'public' => $guideData['public'],
                    'locale' => $guideData['locale'],
                    'type' => $guideData['type'],
                    'url' => $guideData['url'],
                    'documents' => json_encode($guideData['documents']),
                    'flags' => json_encode($guideData['flags']),
                    'image' => json_encode($guideData['image']),
                    'prerequisites' => json_encode($guideData['prerequisites']),
                    'steps' => json_encode($guideData['steps']),
                    'tools' => json_encode($guideData['tools']),
                    'author_id' => $guideData['author']['userid'],
                    'author_username' => $guideData['author']['username'],
                    'author_image' => json_encode($guideData['author']['image']),
                    'created_date' => date('Y-m-d H:i:s', $guideData['created_date']),
                    'published_date' => isset($guideData['published_date']) ? date('Y-m-d H:i:s', $guideData['published_date']) : null,
                    'modified_date' => date('Y-m-d H:i:s', $guideData['modified_date']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $guide = Guide::where('guide_id', $guideData['guideid'])->first();
            $tr = new GoogleTranslate();

            $guide->title = $tr->setSource('en')->setTarget('ca')->translate($guideData['title']);
            $guide->category = $tr->setSource('en')->setTarget('ca')->translate($guideData['category']);
            $guide->subject = $tr->setSource('en')->setTarget('ca')->translate($guideData['subject']);
            $guide->summary = $tr->setSource('en')->setTarget('ca')->translate($guideData['summary']);
            $guide->introduction_rendered = $tr->setSource('en')->setTarget('ca')->translate($guideData['introduction_rendered']);
            $guide->conclusion_rendered = $tr->setSource('en')->setTarget('ca')->translate($guideData['conclusion_rendered']);

            // Traducir los steps línea por línea
            // dd($guideData['steps']); // Eliminar esta línea después de la inspección
            $steps = $guideData['steps']; // Asignar directamente el array
            if (is_array($steps)) {
                foreach ($steps as &$step) {
                    if (isset($step['lines']) && is_array($step['lines'])) {
                        foreach ($step['lines'] as &$line) {
                            if (isset($line['text_raw'])) {
                                $line['text_rendered'] = $tr->setSource('en')->setTarget('ca')->translate($line['text_raw']);
                            }
                        }
                    }
                }
                $guide->steps = json_encode($steps);
            }

            $guide->save();
        }
    }
}
