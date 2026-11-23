<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::withCount('users')->orderBy('name')->get();
        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('admin.classrooms.form', ['classroom' => new Classroom]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:classrooms,name'],
        ]);
        Classroom::create($data);

        return redirect()->route('admin.classrooms.index')->with('success', 'Kelas ditambahkan.');
    }

    public function edit(Classroom $classroom)
    {
        return view('admin.classrooms.form', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('classrooms', 'name')->ignore($classroom->id)],
        ]);
        $classroom->update($data);

        return redirect()->route('admin.classrooms.index')->with('success', 'Kelas diperbarui.');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('admin.classrooms.index')->with('success', 'Kelas dihapus.');
    }
}