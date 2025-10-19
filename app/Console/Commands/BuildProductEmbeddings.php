<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\OllamaService;
use App\Models\Product;

class BuildProductEmbeddings extends Command
{
    protected $signature = 'emb:products';
    protected $description = 'Bangun embedding dari tabel products untuk RAG';

    public function handle(OllamaService $ollama)
    {
        $products = Product::all();

        foreach ($products as $product) {
            $certificateClass = $product->certificate_class ? $product->certificate_class : '-';
            $certificateNumber = $product->certificate_number ? $product->certificate_number : '-';
            $validUntil = $product->valid_until ? $product->valid_until : '-';

            $raw = "{$product->product_name}. {$product->description}. "
                . "Harga: {$product->price_per_unit} {$product->unit}. "
                . "Stok: {$product->stock}. Sertifikat: {$certificateClass} "
                . "Nomor: {$certificateNumber} Berlaku s/d: {$validUntil}";

            $vec = $ollama->embed($raw);

            DB::table('doc_embeddings')
                ->where('source_table', 'products')
                ->where('source_id', $product->product_id)
                ->delete();

            DB::table('doc_embeddings')->insert([
                'source_table' => 'products',
                'source_id'    => $product->product_id,
                'chunk'        => $raw,
                'embedding'    => json_encode($vec),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            $this->info("OK: {$product->product_name}");
        }

        $this->info('Selesai membangun embedding produk.');
    }
}
