<?php

namespace App\Http\Controllers\Api;

require_once app_path() . '/helpers/helpers.php';

use App\Http\Controllers\Controller;
use App\Models\Article;
use Exception;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function listArticle()
    {
        try {
            $this->authorize('student-view-any', Article::class);

            $articles = Article::with('user')->latest()->limit(5)->get();

            $data = [];

            foreach ($articles as $article) {
                $data[] = [
                    'id' => $article->id,
                    'title' => $article->title,
                    'cover' => $article->banner,
                    'writter' => $article->user->name,
                    'date' => generateDate($article->date->toDateString()),
                    'content' => $article->content
                ];
            }
            return response()->json([
                'status' => 200,
                'listArticle' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function detailArticle(Article $article)
    {
        $this->authorize('student-view-any', Article::class);

        try {

            return response()->json([
                'status' => 200,
                'article' => [
                    'id' => $article->id,
                    'title' => $article->title,
                    'cover' => $article->banner,
                    'writter' => $article->user->name,
                    'date' => generateDate($article->date->toDateString()),
                    'content' => $article->content
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
