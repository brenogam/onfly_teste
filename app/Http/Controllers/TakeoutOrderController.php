<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TakeoutOrder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class TakeoutOrderController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            $data = $request->validate([
                'nome_solicitante' => 'required|string',
                'destino' => 'required|string',
                'data_ida' => 'required|date',
                'data_volta' => 'required|date|after_or_equal:data_ida',
            ]);

            $pedido = TakeoutOrder::create($data);

            return response()->json($pedido, 201);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Erro de validação',
                'mensagem' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao criar pedido',
                'mensagem' => $e->getMessage()
            ], 500);
        }
    }

    public function updateOrder(Request $request, $id)
    {
        try {
            $pedido = TakeoutOrder::findOrFail($id);
            $data = $request->validate([
                'status' => 'required|in:aprovado,cancelado',
            ]);

            $pedido->status = $data['status'];
            
            $pedido->save();

            return response()->json($pedido);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Pedido não encontrado',
                'mensagem' => 'O pedido com o ID fornecido não foi encontrado.'
            ], 404);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Erro de validação',
                'mensagem' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao atualizar status do pedido',
                'mensagem' => $e->getMessage()
            ], 500);
        }
    }

    public function consultOrder($id)
    {
        try {
            $pedido = TakeoutOrder::findOrFail($id);
            return response()->json($pedido);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Pedido não encontrado',
                'mensagem' => 'O pedido com o ID fornecido não foi encontrado.'
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao consultar pedido',
                'mensagem' => $e->getMessage()
            ], 500);
        }
    }

    public function indexOrders(Request $request)
    {
        try {
            $status = $request->query('status');
            $pedidos = $status ? 
                TakeoutOrder::where('status', $status)->get() : 
                TakeoutOrder::all();

            return response()->json($pedidos);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao listar pedidos',
                'mensagem' => $e->getMessage()
            ], 500);
        }
    }
}