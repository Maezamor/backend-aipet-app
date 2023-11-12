<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class TypeController extends Controller
{
    public function get(): JsonResponse
    {
        $type = Type::all();

        return response()->json([
            "data" => $type
        ])->setStatusCode(200);
    }
    public function create(Request $request): JsonResponse
    {
        $validator =  Validator::make($request->all(), [
            'type' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $type = Type::create([
            'type' => $request->type
        ]);

        return response()->json([
            'data' => $type
        ]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $validator =  Validator::make($request->all(), [
            'type' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $type = Type::where('id', $id)->first();
        if (!$type) {
            return response()->json(['errors' => ['message' => 'not found']], 404);
        }
        $type->update([
            'type' => $request->type
        ]);
        $type->save();

        return response()->json([
            "data" => $type
        ])->setStatusCode(200);
    }

    public function delete(int $id)
    {
        $type =  Type::where('id', $id)->first();
        $type->delete();

        return response()->json([
            "data" => true
        ])->setStatusCode(200);
    }
}