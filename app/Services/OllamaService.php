<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class OllamaService
{
    private string $base = 'http://127.0.0.1:11434/api';

    public function generate(string $prompt, array $options=[]): string {
        $res = Http::timeout(180)->post($this->base.'/generate', [
            'model'   => 'gemma:2b-instruct',
            'prompt'  => $prompt,
            'stream'  => false,
            'options' => array_merge(['temperature'=>0.2,'num_ctx'=>2048], $options),
        ]);
        return $res->json('response') ?? '';
    }

    public function embed(string $text): array {
        $res = Http::timeout(600)->post($this->base.'/embeddings', [
            'model'  => 'nomic-embed-text',
            'prompt' => $text,
        ]);
        return $res->json('embedding') ?? [];
    }
}
