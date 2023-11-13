<?php

namespace App\Http\Controllers;

use App\Models\Product\Categories; // Se agregó la extensión \Product\Categories ya que el modelo "Categories" se encuentra dentro del directorio "product"
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $categories = Categories::where('name', 'like', '%'.$search.'%')->orderBy('id', 'desc')->paginate(20);

        return response()->json([
            "total" => $categories->total(),
            'categories' => $categories
        ], 200);
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
        // if($request->hasFile('imagen_file')){
        //     $path = Storage::putFile('categorias', $request->file('imagen_file'));
        //     $request->request->add(['imagen_file' => $path]);
        // }

        // Obtenemos los datos del archivo que se subió
        $image = $request->file('image_file');
        $path = 'uploads/categories';

        // Creamos un nombre aleatorio para el archivo
        $nameImage = Str::uuid() . "." . $image->extension();

        // Pasamos como parametro la imagen que se quiere subír a la función de Intervention.io
        // De esta forma vamos a poder manipular la imagen antes de subirla al servidor
        $imageServer = Image::make($image);
        $imageServer->fit(1000, 1000, null, 'center'); // Redimensionamos la imagen a 1000x1000px y definimos que corte en el centro

        // Validamos si existe el directorio
        if(!file_exists(public_path($path))){
            // Si no existe creamos el directorio
            mkdir(public_path($path), 0777, true);
        }

        // Definimos la ruta donde vamos a almacenar la imagen
        $imagePath = public_path($path . '/' . $nameImage);
        // Guardamos la imagen en la ruta definida
        $imageServer->save($imagePath);
        // Añadimos el nombre de la imagen al array de la solicitud
        $request['image'] = $nameImage;

        // Crear la categoría con los datos de la solicitud
        $categorie = Categories::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'CATEGORÍA CREADA CORRECTAMENTE',
            'categorie' => $categorie
        ], 200);
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
        $categorie = Categories::findOrFail($id);
        $path = 'uploads/categories';

        if($request->hasFile('image_file')){
            $completePath = public_path($path . $categorie->image);

            // File::exists() => Función que permite verificar si el archivo existe en el servidor.
            // Parametro => Ruta del archivo que se desea verificar.
            if(File::exists($completePath)) {
                // unlink() => Función que permite eliminar un archivo fisico del servidor.
                // Parametro => Ruta del archivo que se desea eliminar.
                unlink($completePath);
            }

            // Obtenemos los datos del archivo que se subió
            $image = $request->file('image_file');


            // Creamos un nombre aleatorio para el archivo
            $nameImage = Str::uuid() . "." . $image->extension();

            // Pasamos como parametro la imagen que se quiere subír a la función de Intervention.io
            // De esta forma vamos a poder manipular la imagen antes de subirla al servidor
            $imageServer = Image::make($image);
            $imageServer->fit(1000, 1000, null, 'center'); // Redimensionamos la imagen a 1000x1000px y definimos que corte en el centro

            // Validamos si existe el directorio
            if(!file_exists(public_path($path))){
                // Si no existe creamos el directorio
                mkdir(public_path($path), 0777, true);
            }

            // Definimos la ruta donde vamos a almacenar la imagen
            $imagePath = public_path($path . '/' . $nameImage);
            // Guardamos la imagen en la ruta definida
            $imageServer->save($imagePath);
            // Añadimos el nombre de la imagen al array de la solicitud
            $request['image'] = $nameImage;
        }

        // Actualiza la cateoría con los nuevos datos
        $categorie->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'CATEGORÍA ACTUALIZADA CORRECTAMENTE',
            'categorie' => $categorie
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categorie = Categories::findOrFail($id);
        $path = 'uploads/categories/';

        if ($categorie->image) {
            $completePath = public_path($path . $categorie->image);

            // File::exists() => Función que permite verificar si el archivo existe en el servidor.
            // Parametro => Ruta del archivo que se desea verificar.
            if(File::exists($completePath)) {
                // unlink() => Función que permite eliminar un archivo fisico del servidor.
                // Parametro => Ruta del archivo que se desea eliminar.
                unlink($completePath);
            }
        }
        // Elimina la categoría seleccionada de forma suve, es decir que no elimina
        // el registro de la categoría en la base de datos, sino que le agregea una fecha y hora
        // en el campo "delete_at". Esto es gracias a que en la migración agregamos las configuraciones
        // necesarias para el softDelete.
        $categorie->delete();
        return response()->json([
            'status' => true,
            'message' => 'Categoría eliminada exitosamente'
        ], 200);
    }
}
