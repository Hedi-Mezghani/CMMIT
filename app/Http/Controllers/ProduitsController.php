<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Category;
use Illuminate\Http\Request;

class ProduitsController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
        }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $produits=Produit::all();
        return view("produits.index",compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view("produits.create",compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['nom'=>'required',
        'desc'=>'required',
        'prix'=>'required',
        'photo'=>'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'category_id'=>'required',
        ]);
        $inputs=$request->all();
        //traitement de l'image
        if($photo=$request->file("photo")){
            $newfile=strtotime(date("Y-m-d H:i:s")).".".$photo->getClientOriginalExtension();
            $photo->move('images/produits/',$newfile);
            $inputs['photo']=$newfile;
            }
        Produit::create($inputs);
return redirect()->route('produits.index')->with('success','Produit créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
        $categories=Category::all();
        return view("produits.edit",compact('produit','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produit $produit)
    {
        $request->validate(['nom'=>'required',
        'desc'=>'required',
        'prix'=>'required',
        'category_id'=>'required',
        ]);

        $inputs=$request->all();
        //traitement de l'image
        if($photo=$request->file("photo")){
            $newfile=strtotime(date("Y-m-d H:i:s")).".".$photo->getClientOriginalExtension();
            //supprimer l'ancienne photo
            rename('images/produits/'.$produit->photo,'images/corbeille/'.$produit->photo);
            $photo->move('images/produits/',$newfile);
            $inputs['photo']=$newfile;
            }
        $produit->update($inputs);
        return redirect()->route('produits.index')->with('success','Produit modifié avec succès.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        //suppression du fichier image
        unlink("images/produits/".$produit->photo);
        $produit->delete();
return redirect()->route('produits.index')
->with('success','produit supprimé avec succès');

    }
}
