<?php

namespace App\Http\Controllers\ListTo;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListTo\ListToRequest;
use App\Models\ListTo\ListTo;
use Illuminate\Http\Request;

class ListToController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            $perPage = $request->has('length') ? $request->get('length') : 10;

            $queryBuilder = ListTo::query();

            if ($request->filled('relationship')) {
                $relationships = array_map('trim', explode(',', $request->get('relationship')));
                $queryBuilder->with($relationships);
            }

            if ($request->filled('user_id')) {
                $queryBuilder->where('user_id', '=', $request->get('user_id'));
            }

            if ($request->filled('order')) {
                list($field, $order) = explode(',', $request->get('order'));
                $queryBuilder->orderBy($field, $order);
            }

            $count = $queryBuilder->count();
            $data = $queryBuilder->simplePaginate($perPage);

            return response()->json([
                'message' => 'Lista de tarefas encontradas com sucesso.',
                'recordsTotal' => intval($count),
                'data' => $data->items()
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Falha ao buscar a lista de tarefas.',
                'exception' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ListToRequest $request)
    {
        try {

            ListTo::create([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'color' => $request->color,
            ]);

            return response()->json(['message' => 'Listam de tarefas cadastrada com sucesso.'], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Falha ao cadastrar lista de tarefas.',
                'exception' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $queryBuilder = ListTo::query();

            if ($request->filled('relationship')) {
                $relationships = array_map('trim', explode(',', $request->get('relationship')));
                $queryBuilder->with($relationships);
            }

            $data = $queryBuilder->find($id);

            if (!$data) {
                return response()->json([
                    'message' => 'Lista de tarefas não foi encontrada.',
                ], 404);
            }

            return response()->json([
                'message' => 'Lista de tarefas encontrada com sucesso.',
                'data' => $data,
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Falha ao encontrar a lista de tarefas.',
                'exception' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = ListTo::find($id);

            if (!$data) {
                return response()->json([
                    'message' => 'Lista de tarefas não foi encontrada.',
                ], 404);
            }

            $data->name = $request->name;
            $data->color = $request->color;
            $data->position = $request->position;
            $data->is_archived = $request->is_archived;
            $data->save();

            return response()->json(['message' => 'Impulsionamento atualizado com sucesso.'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Falha ao atualizar impulsionamento.',
                'exception' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = ListTo::find($id);

            if (!$data) {
                return response()->json([
                    'message' => 'Lista de tarefas não foi encontrada.',
                ], 404);
            }

            ListTo::destroy($id);

            return response()->json(['message' => 'Lista de tarefas deletada com sucesso.'], 200);
        } catch (\Illuminate\Database\QueryException $e) {

            return response()->json([
                'message' => 'Falha ao deletar lista de tarefas.',
                'exception' => $e->getMessage(),
            ], 400);
        }
    }
}
