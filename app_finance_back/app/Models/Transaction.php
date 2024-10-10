<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Transaction",
 *     type="object",
 *     required={"user_id", "amount", "type"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="amount", type="number", format="float", example=100.50),
 *     @OA\Property(property="type", type="string", enum={"income", "expense"}, example="income"),
 *     @OA\Property(property="description", type="string", example="Salary payment"),
 *     @OA\Property(property="date", type="string", format="date", example="2024-09-01"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
 * )
 */

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'amount', 'type', 'description', 'date', 'categorie'
    ];
}
