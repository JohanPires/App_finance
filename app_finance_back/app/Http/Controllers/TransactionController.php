<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * @OA\Tag(
 *     name="Transaction",
 *     description="Operations related to transactions"
 * )
 */

class TransactionController extends Controller
{

      /**
     * @OA\Get(
     *     path="/api/transactions/{id}",
     *     summary="Obtenir toutes les transactions d'un utilisateur",
     *     tags={"Transaction"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste des transactions de l'utilisateur",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Transaction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transactions non trouvées"
     *     )
     * )
     */
    public function index($id) {
        return Transaction::where('user_id', $id)->get();
    }
 /**
     * @OA\Post(
     *     path="/api/transactions",
     *     summary="Créer une nouvelle transaction",
     *     tags={"Transaction"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","amount","type"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="amount", type="number", format="float", example=100.50),
     *             @OA\Property(property="type", type="string", enum={"income","expense"}, example="income"),
     *             @OA\Property(property="description", type="string", example="Salary payment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Transaction créée avec succès",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Transaction"
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'description' => 'string|nullable',
            'categorie' => 'string|nullable',
            'date' => 'string|nullable',
        ]);


        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
            'categorie' => $request->categorie,
            'date' => $request->date,
        ]);

        return response()->json($transaction, 201);
    }

     /**
     * @OA\Put(
     *     path="/api/transactions/{id}",
     *     summary="Mettre à jour une transaction",
     *     tags={"Transaction"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la transaction",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","amount","type"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="amount", type="number", format="float", example=100.50),
     *             @OA\Property(property="type", type="string", enum={"income","expense"}, example="income"),
     *             @OA\Property(property="description", type="string", example="Updated description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction mise à jour avec succès",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Transaction"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction non trouvée"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        $request->validate([
            'user_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'description' => 'string|nullable',
            'date' => 'string|nullable',
            'categories' => 'string|nullable',
        ]);


        $transaction->update([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return response()->json($transaction, 201);
    }
     /**
     * @OA\Delete(
     *     path="/api/transactions/{id}",
     *     summary="Supprimer une transaction",
     *     tags={"Transaction"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la transaction",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction supprimée avec succès",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Transaction"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction non trouvée"
     *     )
     * )
     */

    public function delete($id)
    {
        $transaction = Transaction::find($id);

        $transaction->delete();

        return response()->json($transaction, 201);
    }

        /**
     * @OA\Get(
     *     path="/api/transactions/total/{id}",
     *     summary="Calculer le montant total des transactions d'un utilisateur",
     *     tags={"Transaction"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Montant total des transactions",
     *         @OA\JsonContent(
     *             @OA\Property(property="total", type="number", format="float", example=200.00)
     *         )
     *     )
     * )
     */

    public function totalAmount($id) {
        $allTransactions =Transaction::where('user_id',$id)->get();
        $income = 0;
        $expense = 0;

        foreach ($allTransactions as $transaction) {
            if($transaction->type === 'income'){
                $income += $transaction->amount;
            } else {
                $expense += $transaction->amount;
            }
        }


        $total = $income - $expense;
        return response()->json(['total' => $total], 201);
    }


}
