<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Family $family
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Family $family): JsonResponse
    {
        try {
            // Build the family tree
            $family = $family->all();

            // Check if the family tree is empty
            if ($family->isEmpty()) {
                // Throw an exception
                throw new \Exception('Family tree is empty', Response::HTTP_NOT_FOUND);
            }

            // Return the response
            return response()->json([
                'status'    => 'success',
                'data'      => $family,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Return the response
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Family $family
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Family $family): JsonResponse
    {
        try {
            // Validate the request
            $request->validate($family->rules);

            // Check if the family name is already exists
            if ($family->where('name', '=', $request->name)->exists()) {
                // Throw an exception
                throw new \Exception('Family name is already exists', Response::HTTP_CONFLICT);
            }

            // Data to be stored
            $data = [
                'name'      => $request->name,
                'gender'    => $request->gender,
                'parent_id' => $request->parent
            ];

            // Store the data to the database
            $familySave = $family->create($data);

            // Check if the data is successfully stored
            if (!$familySave) {
                // Throw an exception
                throw new \Exception('Failed to store the data', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // Return the response
            return response()->json([
                'status'    => 'success',
                'message'   => 'Data successfully stored',
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Return the response
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Family $family
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Family $family, $id): JsonResponse
    {
        try {
            // Get the family tree
            $family = $family->find($id);

            // Check if the family tree is empty
            if (empty($family)) {
                // Throw an exception
                throw new \Exception('Family tree is empty', Response::HTTP_NOT_FOUND);
            }

            // Return the response
            return response()->json([
                'status'    => 'success',
                'data'      => $family,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Return the response
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Family $family
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Family $family, $id): JsonResponse
    {
        try {
            // Validate the request
            $request->validate($family->rules);

            // Get the family tree
            $family = $family->find($id);

            // Check if the family tree is empty
            if (empty($family)) {
                // Throw an exception
                throw new \Exception('Family tree is empty', Response::HTTP_NOT_FOUND);
            }

            // Data to be updated
            $data = [
                'name'      => $request->name,
                'gender'    => $request->gender,
                'parent_id' => $request->parent
            ];

            // Update the data to the database
            $familyUpdate = $family->update($data);

            // Check if the data is successfully updated
            if (!$familyUpdate) {
                // Throw an exception
                throw new \Exception('Failed to update the data', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // Return the response
            return response()->json([
                'status'    => 'success',
                'message'   => 'Data successfully updated',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Return the response
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Family $family
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Family $family, $id): JsonResponse
    {
        try {
            // Get the family tree
            $family = $family->find($id);

            // Check if the family tree is empty
            if (empty($family)) {
                // Throw an exception
                throw new \Exception('Family tree is empty', Response::HTTP_NOT_FOUND);
            }

            // Delete the data from the database
            $familyDelete = $family->delete();

            // Check if the data is successfully deleted
            if (!$familyDelete) {
                // Throw an exception
                throw new \Exception('Failed to delete the data', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // Return the response
            return response()->json([
                'status'    => 'success',
                'message'   => 'Data successfully deleted',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Return the response
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
