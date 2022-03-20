<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Search for all articles
        $articles = Article::all();

        // Return response
        return response()->json([
            'articles' => $articles,
            'message' => 'Artigos carregados com sucesso.'
        ], Response::HTTP_OK);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validate input values
        $request->validate([
            'article_name' => 'required|max:255',
            'article_code' => 'required|max:255',
            'article_price' => 'required'
        ]);

        try {
        
            // Populate database
            $article = new Article;
            $article->name = $request->article_name;
            $article->code = $request->article_code;
            $article->unit_price = $request->article_price;
            $article->save();

            // Return response
            return response()->json([
                'message' => 'Artigo cadastrado com sucesso.'
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            
            // Return error message
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $article = Article::select('id', 'name', 'code', 'unit_price')->findOrFail($id);

        // Return response
        return response()->json([
            'article' => $article,
            'message' => 'Artigo carregado com sucesso.'
        ], Response::HTTP_OK);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {

        // Validate input values
        $request->validate([
            'article_name' => 'required|max:255',
            'article_code' => 'required|max:255',
            'article_price' => 'required'
        ]);

        try {
        
            // Populate database
            $article->name = $request->article_name;
            $article->code = $request->article_code;
            $article->unit_price = $request->article_price;
            $article->save();

            // Return response
            return response()->json([
                'message' => 'Artigo atualizado com sucesso!'
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            
            // Return error message
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        try {

            $article->delete();

            // Return response
            return response()->json([
                'message' => 'Artigo deletado com sucesso!'
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            
            // Return error message
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);

        }

    }
}
