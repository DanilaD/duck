<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteDuckJob;
use App\Jobs\UpdateDuckJob;
use App\Models\DuckModel;
use App\Models\StatusModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class DuckController extends Controller
{
    // Pagination count
    protected int $pagination = 10;

    /**
     * Display a listing of ducks with pagination.
     *
     * @return View
     */
    public function index(): View
    {
        // Fetch paginated list of ducks and all statuses
        $ducks = DuckModel::paginate($this->pagination);
        $statuses = StatusModel::getAll();

        // Return the view with the ducks and statuses data
        return view('ducks.index', compact('ducks', 'statuses'));
    }

    /**
     * Show the form for editing the specified duck.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        // Find the duck by its ID or fail
        $duck = DuckModel::findOrFail($id);
        $statuses = StatusModel::getAll();

        // Return the edit view with the duck and statuses data
        return view('ducks.edit', compact('duck', 'statuses'));
    }

    /**
     * Update the specified duck in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name'                              => 'required|string|max:255',
            'age'                               => 'required|integer',
            'health'                            => 'required|integer',
            'status'                            => 'required|string|max:255',
            'last_fed_time'                     => 'required|date',
            'behaviors.walking.is_walking'      => 'nullable|boolean',
            'behaviors.walking.speed'           => 'nullable|numeric',
            'behaviors.breathing.is_breathing'  => 'nullable|boolean',
            'behaviors.breathing.rate'          => 'nullable|integer',
            'behaviors.quacking.is_quacking'    => 'nullable|boolean',
            'behaviors.quacking.volume'         => 'nullable|string|max:255',
        ]);

        // Dispatch a job to update the duck asynchronously
        UpdateDuckJob::dispatch($id, $validatedData);

        // Redirect back to the ducks index with a success message
        return redirect()->route('ducks.index')->with('success', 'Duck updated successfully.');
    }

    /**
     * Remove the specified duck from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        // Dispatch a job to update the duck asynchronously
        DeleteDuckJob::dispatch($id);

        // Return the search results as a JSON response
        return response()->json(['success' => true]);
    }

    /**
     * Search ducks based on the provided criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        // Validate the search criteria
        $validator = Validator::make($request->all(), [
            'name'   => 'nullable|string',
            'age'    => 'nullable|integer',
            'status' => 'nullable|string',
        ]);

        // If validation fails, return a JSON response with the errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Build the search query
        $search = [
            'name'   => $request->input('name'),
            'age'    => (int)$request->input('age'),
            'status' => $request->input('status'),
        ];

        // Get the search results from the database
        $query = DuckModel::searchQuery($search);
        $results = $query->get();

        // Return the search results as a JSON response
        return response()->json($results);
    }

    /**
     * Get the unique ages of ducks.
     *
     * @return JsonResponse
     */
    public function ages(): JsonResponse
    {
        // Get the unique ages of ducks from the database
        $ages = DuckModel::getUniqueAges();

        // Return the ages as a JSON response
        return response()->json($ages);
    }
}
