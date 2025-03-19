<?php
namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
  
    public function index()
    {
         $cars = Car::with('user')->get(); 

        return response()->json($cars);
    }




   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
           'price' => 'required|numeric|min:0',

          ]);

        $car = Car::create([
            'user_id' => Auth::id(), 
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'price' => $validated['price_per_day'],
 ]);

        return response()->json($car, 201);
    }










    public function show($id)
    {
        $car = Car::with('user')->find($id);

        if (!$car) {
         
            return response()->json(['message' => 'Car not found'], 404);
        
        }

        return response()->json($car);
    }

    public function update(Request $request, $id)
    {
        $car = Car::find($id);

        if (!$car || $car->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized or car not found'], 403);
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

        if (!$car || $car->user_id !== Auth::id()) {
      return response()->json(['message' => 'Unauthorized or car not found'], 403);
    
    }

        $car->delete();

        return response()->json(['message' => 'Car deleted successfully']);
    }
}
