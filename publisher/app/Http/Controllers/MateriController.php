<?php

namespace App\Http\Controllers;

use App\PubMateriService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $body = [
                "user_id" => auth()->user()->id,
                "title" => $request->title,
                "category" => $request->category,
                "content" => $request->content
            ];

            Http::post('http://127.0.0.1:8888/api/materi', 
                $body
            );
            return redirect()->back();
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $request->validate([
                "title" => 'required|string',
                "category" => 'required|string',
                "content" => 'required|string',
            ]);

            $body = [
                "materi_id" => $id,
                "title" => $request->title,
                "category" => $request->category,
                "content" => $request->content
            ];
            $message = json_encode($body);

            $publisher = new PubMateriService();
            $publisher->materiUpdate($message);

            return redirect()->back();
            
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $body = [
                "id" => $id
            ];

            $message = json_encode($body);

            $materiPubs = new PubMateriService();
            $materiPubs->materiDelete($message);

            return redirect()->back();
        } catch(\Exception $e){
            return redirect()->back();
        }
        
    }
}
