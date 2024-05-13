<?php

namespace App\Http\Controllers\api;

use App\Models\Materi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
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
            $request->validate([
                'user_id' => 'required',
                'title' => 'required|string',
                'category' => 'required|string',
                'content' => 'required|string',
            ]);
            
            $materi = Materi::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'category' => $request->category,
                'content' => $request->content,
                ''
            ]);
            return [
                'code' => 200,
                'message' => 'success',
                'data' => $materi
            ];
        } catch (\Exception $e){
            return [
                'code' => 200,
                'message' => 'error',
                'data' => $e->getMessage(),
            ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $materi = Materi::where('user_id', $id)->get();

            return [
                'code' => 200,
                'message' => 'success',
                'data' => $materi
            ];
        } catch (\Exception $e){
            return [
                'code' => 200,
                'message' => 'error',
                'data' => $e->getMessage(),
            ];
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
