<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function list()
    {
        $categories = Category::all();

        return view('product.index', compact('categories'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
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
       $validator = Validator::make($request->all(),[
            'id_kategori' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required',
            'diskon' => 'required',
            'bahan' => 'required',
            'tags' => 'required',
            'sku' => 'required',
            'ukuran' => 'required',
            'warna' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:png,jpg,jpeg,webph,JPG,PNG,JPEG,WEBP'
       ]);

       if ($validator->fails()) {
        return response()->json(
            $validator->errors(),
            422
        );
       }

       $input = $request->all();

        if ($request->has('gambar')){
        $gambar = $request->file('gambar');
        $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
        $gambar->move('uploads', $nama_gambar);
        $input['gambar'] = $nama_gambar;

        $Product = Product::create($input);

        return response()->json([
        'success' => true,
        'data' => $Product
        ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $Product)
    {
        return response()->json([
            'success' => true,
            'data' => $Product
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $Product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $Product)
    {

        $validator = Validator::make($request->all(),[
            'id_kategori' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required',
            'diskon' => 'required',
            'bahan' => 'required',
            'tags' => 'required',
            'sku' => 'required',
            'ukuran' => 'required',
            'warna' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:png,jpg,jpeg,webph'
       ]);

       if ($validator->fails()) {
        return response()->json(
            $validator->errors(),
            422
        );
       }

        $input = $request->all();

        if ($request->has('gambar')) {
            File::delete('uploads/' . $Product->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
         }else{
            unset($input['gambar']);

        }


        $Product->update($input);

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $Product

        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $Product)
    {
       File::delete('uploads/' . $Product->gambar);
       $Product->delete();

        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
