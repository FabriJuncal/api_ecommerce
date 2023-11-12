<?php

namespace App\Http\Controllers;

use App\Models\Product\Categories; // Se agregó la extensión \Product\Categories ya que el modelo "Categories" se encuentra dentro del directorio "product"
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::orderBy('id', 'desc')->paginate(20);

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
        $categories = Categories::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'CATEGORÍA CREADA CORRECTAMENTE',
            'categories' => $categories
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
        $categories = Categories::findOrFail($id);
        if($request->hasFile('imagen_file')){
            if($categories->imagen){
                Storage::delete($categories->imagen);
            }
            $path = Storage::putFile('categorias', $request->file('imagen_file'));
            $request->request->add(['imagen_file' => $path]);
        }

        $categories->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Categoría actualizada exitosamente',
            'categories' => $categories
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categories = Categories::findOrFail($id);
        $categories->delete();
        return response()->json([
            'status' => true,
            'message' => 'Categoría eliminada exitosamente'
        ], 200);
    }
}
