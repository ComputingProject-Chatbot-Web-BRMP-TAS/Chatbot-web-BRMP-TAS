<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OllamaService;
use App\Services\RagService;

class ChatbotController extends Controller
{
    private $ollama;
    private $rag;

    public function __construct(OllamaService $ollama, RagService $rag)
    {
        $this->ollama = $ollama;
        $this->rag = $rag;
    }

    private function formatRupiah($angka)
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }

    public function ask(Request $request)
    {
        $question = trim($request->input('question'));

        if (empty($question)) {
            return response()->json(['answer' => 'Tulis pertanyaannya dulu ya.'], 400);
        }

        // Cari konteks produk
        $productChunks = $this->rag->searchProducts($question, 5);
        // Cari konteks artikel
        $articleChunks = $this->rag->searchArticles($question, 5);

        // Format string harga @ produk
        foreach ($productChunks as &$chunk) {
            $chunk['chunk'] = preg_replace_callback(
                '/(\b\d{1,}\b)\s*(gr|kg|buah|mata)/i',
                function ($m) {
                    $angka = intval($m[1]);
                    $unit = strtolower($m[2]);
                    return $this->formatRupiah($angka) . ' per ' . $unit;
                },
                $chunk['chunk']
            );
        }

        $context = implode("\n\n", array_merge(
            array_map(fn($c) => $c['chunk'], $productChunks),
            array_map(fn($c) => $c['chunk'], $articleChunks)
        ));

        if (empty(trim($context))) {
            return response()->json([
                'answer' => 'Maaf, informasi produk atau artikel tidak tersedia dalam database kami.'
            ]);
        }

        $systemPrompt = "
Anda adalah asisten digital pertanian Balai BRMP yang menjawab pertanyaan terkait produk benih, budidaya, dan layanan balai.
Jawaban harus didasarkan hanya pada data di bawah ini.
Jika ada harga, selalu gunakan format Rupiah, contoh: Rp 4.000 per gram.

CONTEXT:
{$context}

PERTANYAAN:
{$question}

JAWABAN:
";

        $answer = $this->ollama->generate($systemPrompt);

        return response()->json(['answer' => trim($answer)]);
    }
}
