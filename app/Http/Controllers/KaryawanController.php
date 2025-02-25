<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Redirect;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {

    }

    public function store(Request $request)
    {
        // Extract type and data from request
        $formData = $request->data;
        $type = $request->type;
        $rules = [];

        if ($type == 'alternative') {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'dob' => 'required|date',
                'role' => 'required',
            ];
            $model = User::class;

            // Set the password as the same as the date of birth
            if (!empty($formData['dob'])) {
                $formData['password'] = bcrypt($formData['dob']);
            }
        } elseif ($type == 'criteria') {
            $rules = [
                'name' => 'required|string|max:255',
                'weight' => 'required|numeric|min:0|max:100',
                'attribute' => 'required|string|max:100'
            ];
            $model = Criteria::class;
        } elseif ($type == 'subcriteria') {
            $rules = [
                'name' => 'required|string|max:255',
                'value' => 'required|numeric|min:0|max:100',
            ];
            $model = SubCriteria::class;
        } else {
            return Redirect::back()
                ->with('error', 'Invalid type specified');
        }

        try {
            $validator = Validator::make($formData, $rules);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->with('error', 'Validation failed');
            }

            // Create data based on type
            $model::create($formData);
            redirect()->back()->with(['refresh' => true, 'message' => 'Item berhasil ditambah']);

        } catch (\Exception $e) {
            return Redirect::back()
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function show()
    {
        try {
            $data = [
                'criteria' => Criteria::all(),
                'alternative' => User::all(),
                'subcriteria' => Subcriteria::with('criteria')->get(),
                'score' => Score::all(),
            ];

            // redirect()->back()->with(['refresh' => true, 'message' => '', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'refresh' => true,
                'message' => 'Error fetching data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $type = $request->type;
        $rules = [];

        if ($type == 'alternative') {
            $rules = [
                'data.id' => 'required|exists:users,id',
                'data.name' => 'required|string|max:255',
            ];
            $model = User::class;
        } elseif ($type == 'criteria') {
            $rules = [
                'data.id' => 'required|exists:criterias,id',
                'data.name' => 'required|string|max:255',
                'data.weight' => 'required|numeric|min:0|max:100',
                'data.attribute' => 'required|string|max:100',
            ];
            $model = Criteria::class;
        } elseif ($type == 'subcriteria') {
            $rules = [
                'data.id' => 'required|exists:sub_criterias,id',
                'data.name' => 'required|string|max:255',
                'data.value' => 'required|numeric|min:0|max:100',
            ];
            $model = SubCriteria::class;
        } else {
            return Redirect::back()
                ->with('message', 'Invalid type specified');
        }

        $validatedData = $request->validate($rules);

        // Find the model by ID
        $item = $model::findOrFail($validatedData['data']['id']);

        // Update the model with validated data
        $item->update($validatedData['data']);

        return Redirect::back()
            ->with('refresh', true)
            ->with('message', 'Item berhasil diupdate');
    }


    public function destroy(string $type, string $id)
    {
        try {
            $model = match ($type) {
                'criteria' => new Criteria(),
                'alternative' => new User(),
                'subcriteria' => new Subcriteria(),
                default => throw new \Exception('Invalid type specified')
            };
            $item = $model::findOrFail($id);
            $item->delete();

            return Redirect::back()
                ->with('refresh', true)
                ->with('message', 'Item berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return Redirect::back()
                ->with('refresh', true)
                ->with('message', 'Data tidak ditemukan');
        } catch (\Exception $e) {
            return Redirect::back()
                ->with('refresh', true)
                ->with('message', 'Invalid type specified');
        }
    }

    public function getSubCriteria()
    {
        // Fetch customers along with their orders
        $criteria = Criteria::with('subcriteria')->get();

        // Return data as JSON
        return response()->json($criteria);
    }

    public function addSubCriteria(Request $request, $criteria_id)
    {
        $validatedData = $request->validate([
            'data.id' => 'required|integer',
            'data.name' => 'required|string|max:255',
            'data.value' => 'required|integer',
        ]);

        try {
            $criteria = Criteria::findOrFail($criteria_id);

            $criteria->subcriteria()->create([
                'criteria_id' => $criteria_id,
                'name' => $validatedData['data']['name'],
                'value' => $validatedData['data']['value']
            ]);

            return Redirect::back()
                ->with('refresh', true)
                ->with('message', 'Item berhasil ditambah');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create subcriteria',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Failed to create subcriteria: ' . $e->getMessage())
                ->with('refresh', true);
        }
    }

    public function addScore(Request $request)
    {
        try {
            $validated = $request->validate([
                'alternative_id' => 'required|exists:users,id', // |exists:users,id',
                'criteria_id' => 'required|exists:criterias,id', // Changed from criterion_id
                'value' => 'required|numeric'
            ]);

            Score::updateOrCreate(
                [
                    'alternative_id' => $validated['alternative_id'],
                    'criteria_id' => $validated['criteria_id'] // Changed from criterion_id
                ],
                ['value' => $validated['value']]
            );

            return Redirect::back()
                ->with('refresh', true)
                ->with('message', 'Item berhasil ditambah');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create subcriteria: ' . $e->getMessage())
                ->with('refresh', true);
        }
    }

    public function getScore()
    {
        $data = [
            'criteria' => Criteria::all(),
            'alternative' => User::all(),
            'subcriteria' => Subcriteria::all(),
            'scores' => Score::all()
        ];

        return response()->json(['data' => $data]);
    }
}
