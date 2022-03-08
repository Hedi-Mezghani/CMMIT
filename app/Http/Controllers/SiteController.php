<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\produit;

class SiteController extends Controller
{
    //accueil
    public function accueil(){
        $categories=Category::all();

        return view('site.accueil',compact('categories'));
    }

    //panier
    public function panier(){
        $categories=Category::all();
        $panier=session()->get('panier');
        if(empty($panier))
        $panier=[];
        //dd($panier);
        return view('site.panier',compact('categories','panier'));
    }

//vider panier
    public function viderpanier(){
        session()->forget('panier');
        return redirect()->route('site.panier')->with('success','votre panier est vide.');

    }
    //checkout
    public function checkout(){
        $categories=Category::all();
        $panier=session()->get('panier');
        if(empty($panier))
        $panier=[];
        return view('site.checkout',compact('categories','panier'));
    }

    public function supplignepanier(int $indice){
        $panier=session()->get('panier');
        unset($panier[$indice]);
        session()->forget('panier');
        session()->put('panier',$panier);
        return redirect()->route('site.panier')->with('success','un produit est supprimé du panier.');

    }
    //About
    public function about(){
        return view('site.about');
    }

    //produits
    public function produits(int $category_id){
        $categories=Category::all();
        $produits=Produit::where(['category_id'=>$category_id])->get();
        return view('site.produits',compact('categories','produits'));
    }

    //contact
    public function contact(){
        return view('site.contact');
    }

    //save
    public function save(Request $request){

       /* $inputs=$request->all();
        $nom=$inputs['nom'];
        $email=$inputs['email'];
        $tel=$inputs['tel'];
        $message=$inputs['message'];*/

        $nom=$request->input('nom');
        $email=$request->input('email');
        $tel=$request->input('tel');
        $message=$request->input('message');

        return view('site.save',compact('nom','email','tel','message'));
    }

    public function addpanier(Request $request){
       //ajouter un produit dans le panier
       //session()->forget('panier');
//vérifier si un produit existe dans le panier
$panier=session()->get('panier');
$trouve=0;
if(!empty($panier)){
foreach($panier as $indice=>$produit){
    if($produit['produit_id']==$request->input('produit_id')){
        $trouve=1;
        $produit['qte']++;
        session()->forget("panier")[$indice];
        session()->push('panier',$produit);
    }
}
}
if($trouve==0)
session()->push('panier', ["produit_id"=>$request->input('produit_id'),"nomproduit"=>$request->input('nomproduit'),"photoproduit"=>$request->input('photoproduit'),"prix"=>$request->input('prix'),"qte"=>1]);

$nbr=count(session()->get('panier'));
       $data[0]= $nbr;
       return json_encode($data);

    }
}

