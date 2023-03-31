<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $clients = Client::all();
    //     return response()->json($clients);
    // }

    // Array de clientes y servicios
    public function index()
    {
        $clients = Client::all();
        $array = [];
        foreach ($clients as $client) {
            $array[]=[
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
                'phone' => $client->phone,
                'address' => $client->address,
                'services' => $client->services,
            ];
        }
        return response()->json($array);
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
        $client = new Client;
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->adress = $request->adress;
        $client->save();
        $data=[
            'message'=>'Client creacted successfuly',
            'client'=>$client
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    // public function show(Client $client)
    // {
    //     return response()->json($client);
    // }

    public function show(Client $client)
    {
        $data=[
            'message'=>'Clients details',
            'client'=>$client,
            'services'=>$client->services
        ];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->adress = $request->adress;
        $client->save();
        $data=[
            'message'=>'Client updated successfuly',
            'client'=>$client
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        $data=[
            'message'=>'Client deleted successfuly',
            'client'=>$client
        ];
        return response()->json($data);
    }

    public function attach(Request $request, Client $client)
    {
        $client = Client::find($request->client_id);
        $client->services()->attach($request->service_id);
        $data = [
            'message' => 'Service attached successfully',
            'client' => $client
        ];
        return response()->json($data);
    }

    // Elimna un servicio de un cliente
    public function detach(Request $request)
    {
        $client = Client::find($request->client_id);
        $client->services()->detach($request->service_id);
        $data = [
            'message' => 'Service detached successfully',
            'client' => $client
        ];
        return response()->json($data);
    }
}
