<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\OllamaService;
use App\Models\Article;

class BuildArticleEmbeddings extends Command
{
    protected $signature = 'emb:articles';
    protected $description = 'Bangun embedding dari tabel articles untuk RAG';

    
    public function handle(OllamaService $ollama)
    {
        $chunkSize = 750;
        $overlap = 200;

        $articles = DB::table('articles')->orderBy('id')->get();

        foreach ($articles as $article) {
            // Bersihkan HTML dan gabungkan judul dan body
            $raw = trim(strip_tags($article->headline . "\n" . $article->body));
            if (empty($raw)) {
                $this->info("Skip article ID {$article->id} karena kosong");
                continue;
            }

            
            // Pisah menjadi chunk dengan overlap
            $chunks = $this->chunkBySentence($raw, 900, 250);

            // Hapus embedding lama untuk artikel ini
            DB::table('doc_embeddings')->where('source_table', 'articles')->where('source_id', $article->id)->delete();

            $insertData = [];
            foreach ($chunks as $chunk) {
                try {
                    $vec = $ollama->embed($chunk);
                    if (empty($vec)) {
                        $this->warn("Embed kosong untuk artikel {$article->id}");
                        continue;
                    }
                    $insertData[] = [
                        'source_table' => 'articles',
                        'source_id'    => $article->id,
                        'chunk'        => $chunk,
                        'embedding'    => json_encode($vec),
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                } catch (\Exception $e) {
                    $this->error("Gagal embed artikel {$article->id}: " . $e->getMessage());
                }
            }

            if (!empty($insertData)) {
                DB::table('doc_embeddings')->insert($insertData);
                $this->info("Selesai membangun embedding artikel ID {$article->id} dengan " . count($insertData) . " chunk");
            }
        }
        $this->info("Semua artikel sudah selesai dibangun embeddingnya.");
    }

    private function chunkBySentence(string $text, int $chunkSize = 900, int $overlap = 250): array
    {
        // Hilangkan tag HTML
        $text = strip_tags($text);

        // Split berdasarkan akhir kalimat dan baris baru
        $segments = preg_split('/(\r?\n|\r\n|\<br\>|\<br\/\>|\. |\! |\? )/', $text, -1, PREG_SPLIT_NO_EMPTY);
        $chunks = [];
        $current = '';
        foreach ($segments as $segment) {
            $segment = trim($segment);
            if (!$segment) continue;
            if (strlen($current . ' ' . $segment) < $chunkSize) {
                $current .= ($current ? ' ' : '') . $segment;
            } else {
                $chunks[] = trim($current);
                // Ambil overlap belakang chunk sebelumnya
                $current = substr($current, -$overlap) . ' ' . $segment;
            }
        }
        if ($current) $chunks[] = trim($current);
        return $chunks;
    }


}
