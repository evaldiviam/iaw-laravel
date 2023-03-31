# PROYECTO EMPRESA SERVICIOS
Un cliente puede contratar un o varios servicios y un servicio puede ser contratado por uno o varios clientes. Por ejemplo un cliente A puede contratar un servicio de auditoría informática, otro servicio de limpieza de PC's, otro de instalación de servidor web... Un cliente B puede contratar los mismos servicios. En esta relación n-m se necesita una tabla pivote.

1. Crear proyecto
```
composer create-project laravel/laravel api-servicios`
```

2. Crear base de datos y vincular

 ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=api_services
    DB_USERNAME=root
    DB_PASSWORD=
 ```

3. Crear  modelo client con el controlador y las rutas
```
php artisan make:model Client -mcr
```

4. Crear  modelo client con el controlador y las rutas
```
php artisan make:model Service -mcr
```

5. Rellenar migratión __Client__ 
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email")->unique();
            $table->string("phone")->nullable();
            $table->string("address")->nullable();
            $table->timestamps();
        });
    }

6. Rellenar migratión __Service__ 
```
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description")->nullable();
            $table->string("price");
            $table->timestamps();
        });
    }
```    

7. Crear tabla pivote (serguir la nomeclatura)
```
php artisan make:migration create_client_service_table
```

8. Rellenar los modelos Client y Service con las relaciones 1-N

EN EL MODELO CLIENT
```
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
```

EN EL MODELO SERVICE
```
    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
```

9. Rellenar migratión __create_clients_services_table__ 
```
    public function up()
    {
        Schema::create('client_service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('service');
            $table->timestamps();
        });
    }
```


10. Implementar las funciones de los controladores

11. Ejecutar las migraciones
```
php artisan migrate
```

12. Crear rutas de clientes y servicios en archivo routes/api.php (añadir use de los controladores)
```
Route::get('/clients', 'ClientController@index');
Route::post('/clients', 'ClientController@store');
Route::get('/clients/{client}', 'ClientController@show');
Route::put('/clients/{client}', 'ClientController@update');
Route::delete('/clients/{client}', 'ClientController@destroy');

Route::get('/services', 'ServiceController@index');
Route::post('/services', 'ServiceController@store');
Route::get('/services/{service}', 'ServiceController@show');
Route::put('/services/{service}', 'ServiceController@update');
Route::delete('/services/{service}', 'ServiceController@destroy');
```

13. Levantar el servidor
```
php artisan serve
```

## Utilizar la tabla pivote

1. Crear función attach en Http/Controllers/ClientContoller.php

```
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
```

2. Añadir ruta para guardar datos en la tabla pivote 'clients_services'
```
    Route::post('/clients/services', 'ClientController@attach');`
```

3. Realizar detach: routa 


## ENDPOINTS

URL: /api/clients

### Guardar data en tabla pivote
Utilizando verbo http post

```
{
    "client_id":1,
    "service_id":1
}
```


# Referencias
https://www.danielprimo.io/blog/laravel-series-ii-instalacion-artisan
https://styde.net/artisan-interfaz-linea-comandos-de-laravel/