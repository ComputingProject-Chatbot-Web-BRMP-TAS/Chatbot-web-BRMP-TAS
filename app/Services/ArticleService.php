<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ArticleService
{
    /**
     * Create new article
     */
    public function createArticle(array $data, $imageFile = null)
    {
        try {
            DB::beginTransaction();

            if ($imageFile) {
                $data['image'] = $imageFile->store('articles', 'public');
            }

            $article = Article::create($data);

            Log::info('Article created', [
                'article_id' => $article->id,
                'title' => $article->headline,
                'has_image' => isset($data['image'])
            ]);

            DB::commit();
            return $article;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create article', [
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Update article
     */
    public function updateArticle(Article $article, array $data, $imageFile = null)
    {
        try {
            DB::beginTransaction();

            $oldImage = $article->image;

            if ($imageFile) {
                // Delete old image if exists
                if ($oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
                $data['image'] = $imageFile->store('articles', 'public');
            }

            $article->update($data);

            Log::info('Article updated', [
                'article_id' => $article->id,
                'title' => $article->headline,
                'image_changed' => $imageFile !== null
            ]);

            DB::commit();
            return $article;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update article', [
                'article_id' => $article->id ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Delete article
     */
    public function deleteArticle(Article $article)
    {
        try {
            DB::beginTransaction();

            $articleId = $article->id;
            $headline = $article->headline;

            // Delete associated image
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }

            $article->delete();

            Log::info('Article deleted', [
                'article_id' => $articleId,
                'title' => $headline
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to delete article', [
                'article_id' => $article->id ?? null,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get published articles with pagination
     */
    public function getPublishedArticles($perPage = 10)
    {
        return Article::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get all articles for admin
     */
    public function getAllArticles($perPage = 15)
    {
        return Article::orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Search articles
     */
    public function searchArticles(string $query, $perPage = 10)
    {
        return Article::where('headline', 'LIKE', '%' . $query . '%')
            ->orWhere('body', 'LIKE', '%' . $query . '%')
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get article statistics
     */
    public function getArticleStatistics()
    {
        return [
            'total_articles' => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles' => Article::where('status', 'draft')->count(),
            'articles_this_month' => Article::whereMonth('created_at', now()->month)->count(),
            'recent_articles' => Article::whereDate('created_at', '>=', now()->subDays(7))->count(),
        ];
    }

    /**
     * Validate article data
     */
    public function validateArticleData(array $data)
    {
        $requiredFields = ['headline', 'body'];
        
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new \Exception("Field {$field} is required.");
            }
        }

        if (strlen($data['headline']) > 255) {
            throw new \Exception('Headline must be less than 255 characters.');
        }

        return true;
    }
}