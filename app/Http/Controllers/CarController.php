<?php
namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;


/**
 * @OA\Info(
 *      title="Car API",
 *      version="1.0.0",
 *      description="Car management API"
 * )
 * 
 * @OA\Tag(
 *     name="Cars",
 *     description="Operations related to cars"
 * )
 */


class CarController extends Controller
{


     /**
     * @OA\Get(
     *     path="/api/cars",
     *     summary="Get all cars",
     *     tags={"Cars"},
     *     @OA\Response(
     *         response=200,
     *         description="List of cars",
     *     )
     * )
     */
    
    public function index()
    {
        $cars = Car::all();
        return response()->json($cars);
      }

   
      /**
     * @OA\Post(
     *     path="/api/cars",
     *     summary="Create a new car",
     *     tags={"Cars"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"brand","model","price"},
     *             @OA\Property(property="brand", type="string", example="Toyota"),
     *             @OA\Property(property="model", type="string", example="Corolla"),
     *             @OA\Property(property="price", type="number", example=25000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Car created successfully",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     )
     * )
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
]);

      $car = Car::create($validated);

        return response()->json($car, 201);
    }

   

    /**
     * @OA\Get(
     *     path="/api/cars/{id}",
     *     summary="Get a specific car",
     *     tags={"Cars"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Car ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car details",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Car not found",
     *     )
     * )
     * 
     *  * @OA\Schema(
 *     schema="Car",
 *     type="object",
 *     required={"brand", "model", "price"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="brand", type="string", example="Toyota"),
 *     @OA\Property(property="model", type="string", example="Corolla"),
 *     @OA\Property(property="price", type="number", example=25000),
 * )
 */
     

    public function show($id)
    {
        $car = Car::find($id);

        if (!$car) {
        return response()->json(['message' => 'Car not found'], 404);
        }

        return response()->json($car);
    }



 /**
     * @OA\Put(
     *     path="/api/cars/{id}",
     *     summary="Update a car",
     *     tags={"Cars"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Car ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="brand", type="string", example="Ford"),
     *             @OA\Property(property="model", type="string", example="Focus"),
     *             @OA\Property(property="price", type="number", example=28000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car updated successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Car not found",
     *     )
     * )
     */


     
  
    public function update(Request $request, $id)
    {
        $car = Car::find($id);


        if (!$car) {
              return response()->json(['message' => 'Car not found'], 404);
        }

        $validated = $request->validate([
            'brand' => 'sometimes|string|max:255',
            'model' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
  ]);

        $car->update($validated);

        return response()->json($car);
    }


    /**
     * @OA\Delete(
     *     path="/api/cars/{id}",
     *     summary="Delete a car",
     *     tags={"Cars"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Car ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car deleted successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Car not found",
     *     )
     * )
     */
  
    public function destroy($id)
    {
        
        $car = Car::find($id);

        if (!$car) {
        return response()->json(['message' => 'Car not found'], 404);
        
    }

        $car->delete();

        return response()->json(['message' => 'Car deleted successfully']);
    }
}
