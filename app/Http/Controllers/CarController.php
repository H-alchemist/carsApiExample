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
     *     summary="create car",
     *     tags={"Cars"},
     *     @OA\Response(
     *         response=200,
     *         description="List of cars",
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

   



    public function show($id)
    {
        $car = Car::find($id);

        if (!$car) {
        return response()->json(['message' => 'Car not found'], 404);
        }

        return response()->json($car);
    }




  
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
