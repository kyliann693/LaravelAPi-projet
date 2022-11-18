<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commande = Commande::all();
        if(count($commande) <= 0){
            return response(["message" => "Ce produit n'est pas disponible"], 200);
        }
        return response($commande, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $commandeValidation = $request->validate([
            "produit" => ["required", "string"],
            "price" => ["required", "numeric"],
            "description" => ["required", "string", "min:5"],
            "user_id" => ["required", "numeric"],

        ]);
            
        $commande = Commmande::create([
            "produit" => $commandeValidation["produit"],
            "price" => $commandeValidation["price"],
            "description" => $commandeValidation["description"],
            "user_id" => $commandeValidation["user_id"],
        ]);
        return response(["message" => "Produit ajouté"],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = DB::table("commande")
        ->join("users", "commande.user_id", "=", "users.id")//Jointure avec l'id
        ->select("commande.*", "users.name", "users.email")
        ->where("commande.id", "=", $id)
        ->get()
        ->first();
        return $article;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $id)
    {
        $commandeValidation = $request->validate([
            "produit" => ["string"],
            "price" => ["numeric"],
            "description" => ["string", "min:5"],
            "user_id" => ["required", "numeric"],

        ]);
        $article = Commande::find($id);

        if (!$article) {
            return response(["message" => "Aucun produit trouver"], 404);
        }
        if($article->user_id != $commandeValidation["user_id"]){
            return response(["message" => "Action interdite"], 403);
        }
        $car->update($commandeValidation);
        return response(["message" => "Artcile mis à jour"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {                                                   //vérification de l'utilisateur et destroy    
        $commandeValidation = $request->validate([
            "user_id" => ["required", "numeric"],
        ]);

        $article = Commande::find($id);

        if (!$article) {
            return response(["message" => "Aucun produit trouver"], 404);
        }
        if($article->user_id != $commandeValidation["user_id"]){
            return response(["message" => "Action interdite"], 403);
        }
        $value = Commande::destroy($id);
        if(boolval($value) == false){
            return response(["message" => "Aucun produit trouver"], 404);
        }
        return response(["message" => "article supprimer"], 200);
    }
}
