<?php

use App\Http\Controllers\CommandeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post("/utilisateur/inscription", [UserController::class, "inscription"]);
Route::post("/utilisateur/connexion", [UserController::class, "connexion"]);

Route::get("/commande", [CommandeController::class, "index"]);
Route::get("/commande/{id}", [CommandeController::class, "show"]);


Route::group(["middleware" => ['auth:sanctum']], function(){//Requière la connexion
    Route::post("/commande", [CommandeController::class, "store"]);
    Route::put("/commande/{id}", [CommandeController::class, "update"]);
    Route::delete("/commande/{id}", [CommandeController::class, "destroy"]);
});