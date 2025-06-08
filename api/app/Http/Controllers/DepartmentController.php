<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index(Request $req)
    {
        $req->validate(['center_id' => ['nullable', 'integer', 'exists:centers,id']]);
        $departments = new Department();

        if ($req->filled('center_id')) {
            $departments = $departments->where('center_id', $req->input('center_id'));
        }
        $departments = $departments->get();

        return $this->res_success("get success", $departments);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'unique:departments', 'max:255'],
            'local_name' => ['required', 'string', 'unique:departments', 'max:255'],
            'center_id' => ['required', 'integer', 'exists:centers,id'],
        ]);

        $department = Department::create([
            'name' => $validatedData['name'],
            'local_name' => $validatedData['local_name'],
            'center_id' => $validatedData['center_id'],
        ]);

        return response()->json([
            'result' => true,
            'message' => 'Department created successfully',
            'department' => $department,
        ]);
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $validatedData = $request->validate([
            'name' => ['sometimes', 'string', 'unique:departments,name,' . $id, 'max:255'],
            'local_name' => ['sometimes', 'string', 'unique:departments,local_name,' . $id, 'max:255'],
            'center_id' => ['sometimes', 'exists:centers,id'],
        ]);

        $department->update($request->only(['name', 'local_name', 'center_id', 'specialist_id']));

        return response()->json([
            'result' => true,
            'message' => 'Department updated successfully',
            'department' => $department,
        ]);
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return response()->json([
            'result' => true,
            'message' => 'Department deleted successfully'
        ]);
    }
}
