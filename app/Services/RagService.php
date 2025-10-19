<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class RagService
{
    // Keyword khusus produk
    private function guessProductKeywords(string $query): array
    {
        $q = mb_strtolower($query);
        $map = [
            'tebu' => ['tebu', 'AAS Agribun', 'AMS Agribun', 'ASA Agribun','KK'],
            'tembakau' => ['tembakau', 'tobacco','Kemloko', 'Bligon', 'H 382 T2 Agribun','H 382 T4 Agribun','H 382 T6 Agribun','Semaran Jahe','Jepril','Jinten Pak Pie','Bojonegoro','Prancak','Kasturi'],
            'stevia' => ['stevia', 'pemanis'],
            'wijen' => ['wijen', 'sesame','SBR','WINAS'],
            'kapas' => ['kapas', 'kanesia'],
            'rosela' => ['rosela', 'rosela herbal', 'Roselindo'],
            'kenaf' => ['kenaf', 'KR',],
            'jarak kepyar' => ['jarak kepyar', 'ASB 175 Agribun'],
            'abaka' => ['abaka', 'Abakatas'],
            'rami' => ['rami', 'Ramindo'],
        ];

        foreach ($map as $group => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($q, $keyword)) {
                    return array_unique($keywords);
                }
            }
        }
        // fallback kata kunci produk umum
        return ['harga', 'stok', 'unit', 'benih', 'sertifikat', 'sertifikasi'];
    }

    // Keyword khusus artikel
    private function guessArticleKeywords(string $query): array
    {
        $q = mb_strtolower($query);
        $map = [
            'tebu' => ['tebu'],
            'tembakau' => ['tembakau'],
            'stevia' => ['stevia'],
            'wijen' => ['wijen'],
            'kapas' => ['kapas'],
            'padi' => ['padi'],
        ];

        foreach ($map as $group => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($q, $keyword)) {
                    return array_unique($keywords);
                }
            }
        }
        // fallback kata kunci artikel umum
        return ['budidaya', 'penanaman', 'pengairan', 'pemupukan', 'pestisida', 'hasil'];
    }

    public function searchProducts(string $query, int $k = 5): array
    {
        $qvec = app('App\Services\OllamaService')->embed($query); // panggil Ollama embed service
        $keywords = $this->guessProductKeywords($query);

        $builder = DB::table('doc_embeddings')
            ->where('source_table', 'products')
            ->select('source_id', 'chunk', 'embedding');

        if (!empty($keywords)) {
            $builder->where(function ($q) use ($keywords) {
                foreach ($keywords as $kw) {
                    $q->orWhere('chunk', 'like', '%' . $kw . '%');
                }
            });
        }
        $rows = $builder->limit(4000)->get();

        $scored = [];
        foreach ($rows as $r) {
            $vec = json_decode($r->embedding, true);
            if (!is_array($vec) || empty($vec)) continue;
            $score = $this->cosine($qvec, $vec);
            $scored[] = ['score' => $score, 'chunk' => $r->chunk, 'product_id' => $r->source_id];
        }

        usort($scored, fn($a, $b) => $b['score'] <=> $a['score']);

        $minScore = 0.70;
        $top = array_values(array_filter(array_slice($scored, 0, max($k,10)), fn($x) => $x['score'] >= $minScore));
        if (empty($top)) $top = array_slice($scored, 0, $k);
        else $top = array_slice($top, 0, $k);

        return $top;
    }

    public function searchArticles(string $query, int $k = 5): array
    {
        $qvec = app('App\Services\OllamaService')->embed($query);
        $keywords = $this->guessArticleKeywords($query);

        $builder = DB::table('doc_embeddings')
            ->where('source_table', 'articles')
            ->select('source_id', 'chunk', 'embedding');

        if (!empty($keywords)) {
            $builder->where(function ($q) use ($keywords) {
                foreach ($keywords as $kw) {
                    $q->orWhere('chunk', 'like', '%' . $kw . '%');
                }
            });
        }
        $rows = $builder->limit(4000)->get();

        $scored = [];
        foreach ($rows as $r) {
            $vec = json_decode($r->embedding, true);
            if (!is_array($vec) || empty($vec)) continue;
            $score = $this->cosine($qvec, $vec);
            $scored[] = ['score' => $score, 'chunk' => $r->chunk, 'article_id' => $r->source_id];
        }

        usort($scored, fn($a, $b) => $b['score'] <=> $a['score']);

        $minScore = 0.70;
        $top = array_values(array_filter(array_slice($scored, 0, max($k,10)), fn($x) => $x['score'] >= $minScore));
        if (empty($top)) $top = array_slice($scored, 0, $k);
        else $top = array_slice($top, 0, $k);

        return $top;
    }

    // Contoh fungsi cosine similarity
    private function cosine(array $vec1, array $vec2): float
    {
        $dot = 0.0;
        $normA = 0.0;
        $normB = 0.0;
        for ($i = 0; $i < count($vec1); $i++) {
            $dot += $vec1[$i] * $vec2[$i];
            $normA += $vec1[$i] ** 2;
            $normB += $vec2[$i] ** 2;
        }
        if ($normA == 0.0 || $normB == 0.0) return 0.0;
        else return $dot / (sqrt($normA) * sqrt($normB));
    }
}
