<?php

namespace App\Http\Controllers;

use App\Models\Videogame;
use App\Models\Category;
use Illuminate\Http\Request;


class VideogameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vieogames = Videogames::orderBy("title", "desc").get();
        return response()->json($vieogames);
    }

    public function searchVideogamesByTitle(Request $request)
    {
        if ($request->search){
            $searchVideogames = Videogame::where('title', 'LIKE', '%'.$request->search.'%')->latest()->paginate(15);
            return response()->json($searchVideogames);
        }else{
            $data=[
                'message'=>'Empty search'
            ];
            return response()->json($data);
        }
    }

    public function searchVideogamesByCategory(Request $request)
    {
        if ($request->category_id){
            //$searchVideogames = Videogame::where('category_id', '=', $request->category_id)->latest()->paginate(15);
            $searchVideogames = Videogame::where('category_id', $request->category_id)->get();
            return response()->json($searchVideogames);
        }else{
            $data=[
                'message'=>'Empty search'
            ];
            return response()->json($data);
        }
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
    // public function store(Request $request)
    // {

    //     $validated = $request->validate([
    //         'title' => 'required|min:3|max:255',
    //         'description' => 'max:500',
    //         'stock' => 'numeric',
    //     ]);
        
    //     $videogame = new Videogame;
    //     $videogame->title = $request->title;
    //     $videogame->description = $request->description;
    //     $videogame->price = $request->price;
    //     $videogame->category_id = $request->category_id;
    //     $videogame->save();
    //     $data=[
    //         'message'=>'Videogame creacted successfuly',
    //         'videogame'=>$videogame
    //     ];
    //     return response()->json($data);
    // }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'max:500',
            'stock' => 'numeric',
        ]);
        
        // Videogame::create(
        //     [
        //         'title' => $request->title,
        //         'description' => $request->description,
        //         'category_id' => $request->category_id,
        //         'stock' => $request->stock
        //     ]
        // );
            
        // Si todos los campos se llaman igual que los parámetros request:
        $videogame=Videogame::create($request->all());
        $data=[
            'message'=>'Videogame creacted successfuly',
            'videogame'=>$videogame
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Videogame  $videogame
     * @return \Illuminate\Http\Response
     */
    public function show(Videogame $videogame)
    {
        $data=[
            'message'=>'Videogames details',
            'videogame'=>$videogame
        ];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Videogame  $videogame
     * @return \Illuminate\Http\Response
     */
    public function edit(Videogame $videogame)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Videogame  $videogame
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Videogame $videogame)
    {
        $videogame->title = $request->title;
        $videogame->description = $request->description;
        $videogame->price = $request->price;
        $videogame->category_id = $request->category_id;
        $videogame->save();
        $data=[
            'message'=>'Videogame updated successfuly',
            'videogame'=>$videogame
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Videogame  $videogame
     * @return \Illuminate\Http\Response
     */
    public function destroy(Videogame $videogame)
    {
        $videogame->delete();
        $data=[
            'message'=>'Videogame deleted successfuly',
            'videogame'=>$videogame
        ];
        return response()->json($data);
    }
}
