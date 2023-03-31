# PROJECT VIDEOGAMES

1. Crear proyecto en terminal 
```
composer create-project laravel/laravel api-videogames
```
Podemos abrir proyecto con el comando "code ." ejecutado dentro  el directorio creado.

2. Crear base de datos mysql __"api_videogames"__ y vincular en archivo __.env__ (comprobar puerto y modificar campo DB_DATABASE)

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=api_videogames
DB_USERNAME=root
DB_PASSWORD=
```

3. Crear modelo __Category__ y __Videogame__
```
php artisan make:model Category -mcr
php artisan make:model Videogame -mcr
```

4. Modificar el archivo database/migrations/*create_categories_table.php con los campos:
```
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->default("No description");
            $table->timestamps();
```
5. Modidificar el modelo __App/models/Category.php__ especificando los campos que se puede rellenar
```
 protected $fillable = ['name', 'description'];
```

6. Completar el controlador App/Http/Controllers/CategoryController.php modificando los métodos:
- index
- show
- store
- update
- destroy

7. Modificar el archivo database/migrations/*create_videogames_table.php con los campos:
```
            $table->id();
            $table->string('title')->unique();
            $table->string('description')->default('No description');
            $table->float('price');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->timestamps();
```
8. Modificar el modelo App/models/Videogames.php especificando los campos que se puede rellenar
```
 protected $fillable = ['title', 'description', 'price', 'category_id'];
```

9. Completar el controlador App/Http/Controllers/VideogamesController.php (seguir fichero ejemplo)

10. Crear rutas en __App/routes/api.php__ para Category y Videogame
```
Route::get('/categories', 'App\Http\Controllers\CategoryController@index');
Route::post('/categories', 'App\Http\Controllers\CategoryController@store');
Route::get('/categories/{category}', 'App\Http\Controllers\CategoryController@show');
Route::put('/categories/{category}', 'App\Http\Controllers\CategoryController@update');
Route::delete('/categories/{category}', 'App\Http\Controllers\CategoryController@destroy');

Route::get('/videogames', 'App\Http\Controllers\VideogameController@index');
Route::get('/videogames/search/{videogame}', 'App\Http\Controllers\VideogameController@searchVideogamesByTitle');
Route::post('/videogames', 'App\Http\Controllers\VideogameController@store');
Route::get('/videogames/{videogame}', 'App\Http\Controllers\VideogameController@show');
Route::put('/videogames/{videogame}', 'App\Http\Controllers\VideogameController@update');
Route::delete('/videogames/{videogame}', 'App\Http\Controllers\VideogameController@destroy');
```

11. Ejecutar las migraciones
```
php artisan migrate
```

12. Poner en marcha el servidor
```
php artisan serve
```

## SEEDERS
Permiten la creación de datos iniciales. Seguir los siguientes pasos para cargar las categorías iniciales en la base de datos.

1. Creación de seeders:
```
php artisan make:seeder CategoriesTableSeeder
```

2. Rellenar Migracions/seeders/CategoriesTableSeeder con los objetos de tipo Category (importar Category para poder crear los objectos). Por ejemplo:
```
        $category1=new Category;
        $category1->name="Sports";
        $category1->description="Categoria basada en deportes como fútbol, paddel, tenis...";
        $category1->save();
```

3. Anotar en __DatabaseSeeder.php__ el nuevo seeder:
```
    $this->call([
        CategoriesTableSeeder::class
    ]);
```

4. Ejecutar migración completa (borra las tablas actuales y las vuelve a crear con los datos de carga inicial):
```
php artisan migrate:fresh --seed
```

## Factory
Permiten la carga masiva de datos de prueba.
En el siguiente ejemplos se crear 15 registros de gamers ficticios:

1. Creación del modelo __Gamer__
```
php artisan make:model Gamer -mcr
```
2. Modificar el artchivo __database/migrations/*create_gamer_table.php__ con los campos:
```
    $table->id();
    $table->string("name");
    $table->string("type");
    $table->timestamps();
```

4. Crear factory
```
php artisan make:factory GamerFactory
```
5. Modificar el archivo creado __database/factories/GamerFactory.php__:
```
return [
            "name"=>$this->faker->name(),
            "type"=>$this->faker->randomElement(["PREMIUM","SILVER"])
        ];
```

6.  Anotar en __DatabaseSeeder.php__ el nuevo factory 
```
\App\Models\Gamer::factory(10)->create();
```

7.  Ejecutar migración completa
```
php artisan migrate:fresh --seed
```

## Añadir campos sin borrar base de datos

1. Crear migración para la nueva columna
```
php artisan make:migration add_stock_column_to_videogames_table --table=videogames
```

2. Modificar archivo __add_stock_column_to_videogames_table.php__
```
 $table->integer('stock')->default(0);
```

3.  Ejecutar migración
```
php artisan migrate
```

## Añadir validaciones para los atributos

1. Añadir al métodp __store__ del fichero VideogameController.php la siguiente validación:
```
    $validated = $request->validate([
        'title' => 'required|min:3|max:255',
        'description' => 'max:500',
        'stock' => 'numeric',
    ]);
```

2. Comprobar la respuesta con la petición post de:
En la cabecera de la petición debe aparecer:
"accept"=>"application/json"

```
{
  "title":"Th",
  "description":"info",
  "price":5.5,
  "category_id":1,
  "stock":1
}
```

Las validaciones generan automáticamente un __fichero json__ con los __errores__ encontrados:
```
{
  "message": "The given data was invalid.",
  "errors": {
    "title": [
      "The title must be at least 3 characters."
    ]
  }
}
```

## Asignación masiva

Podemos obviar el nombre de los campos si los parámetros de la solicitud tienen los mismos nombres. Para ello debemos seguir el siguiente proceso:

1. Cambiar el método __store__ por:
```
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
```


## Mapping entre __category__ y los videogames relacionados
Si queremos vincular los modelos con una asociación 1:N (hay varios videojuegos que pertenecen a una categoría) debemos realizar los siguientes cambios en los modelos:

1. Añadir al modelo __Category__ (importar Videogame)
```
    public function videogames()
    {
	    return $this->hasMany(Videogame::class);
    }
```

2. Añadir al modelo __Videogame__ (importar Category)
```
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

```
3. Modificar método __show__ de CategoryContoller
```
      $data=[
            'message'=>'Category details',
            'category'=>$category,
            'videogames'=>$category->videogames
        ];
```

4. Comprobar la URL:
http://127.0.0.1:8000/api/categories/1

## Importar datos de un fichero json a una tabla de base de datos
En este ejemplo se importaran los almacenes.

1. Guardar archivo json "store.json" en database/data/
```
[
    {
        "id": 1,
        "name": "Almacén Alfa",
        "address": "calle sangartana"
    },
    {
        "id": 2,
        "name": "Almacén Beta",
        "address": "calle sapo"
    },
    {
        "id": 3,
        "name":"Almacén Delta",
        "address": "calle serpiente"
    }
]
```

2. Crear store
```
php artisan make:model Store --all
```


3. Añadir columnas en migrations de Store


public function up()
{
    Schema::create('stores', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('address');
        $table->timestamps();
    });
}

4. Crear  seeders de store

```
php artisan make:seeder StoresTableSeeder
```

5. Añadier el código correspondiente al seeder:

Importar clases
```
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use App\Models\Store;
````
...

Añadir función
``

    public function run()
    {
        // Borramos lo que hay he importamos
        DB::table('stores')->delete();
        $json = File::get("database/data/stores.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Store::create(array(
                'name' => $obj->name,
                'address' => $obj->address,
            ));
        }
    }

6. Añadir el nuevo seeder al DatabaseSeeders

```
        $this->call([
            CategoriesTableSeeder::class,
            StoresTableSeeder::class
        ]
        );
```

7. Ejecutar los cambios
php artisan migrate:fresh --seed

## Resolución de errores
Si las migraciones no se cargan correctamente (por ejemplo si intenta crear una tabla que depende de otra) probar con:
```
php artisan migrate:reset
```

## Instalar paquetes de una aplicación en github
Para descargar e instalar los paquetes configurados en el fichero composer.json de una aplicación, usa el comando: 
```
composer install 
```

Este comando lleva a cabo los siguientes pasos:

1. Lee el fichero composer.lock o, si no existe, el fichero composer.json.
2. Busca en Packagist los paquetes especificados en ese fichero.
3. Resuelve la versión a instalar de cada paquete a partir de las versiones indicadas y la configuración de estabilidad.
4. Resuelve todas las dependencias para esas versiones.
5. Instala todos los paquetes y todas las dependencias.
6.Una vez instalados los paquetes, si no existe composer.lock, lo crea para dejar ‘una foto fija’ del entorno de ejecución de la aplicación. También crea los ficheros de autocarga de clases de la aplicación.

El directorio vendor no suele distribuirse con las aplicaciones. Por lo tanto, cuando haces un clone (o un fork y un clone) de un proyecto o aplicación, el primer paso suele ser ejecutar composer install para generar ese directorio e instalar en él todas las dependencias de la aplicación.

Para más información consultar el post:
<https://styde.net/instalar-y-actualizar-paquetes-con-composer/>

## Reference
- https://styde.net/modificar-tablas-ya-existentes-con-las-migraciones-de-laravel/
- https://laracasts.com/discuss/channels/laravel/how-to-show-all-comments-related-to-a-post-by-id
- https://laracasts.com/series/laravel-8-from-scratch