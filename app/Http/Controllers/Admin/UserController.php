<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $filter = $request->query('role');
        $roles = in_array($filter, ['siswa', 'guru']) ? [$filter] : ['siswa', 'guru'];

        $users = User::role($roles)
            ->with(['classroom', 'roles'])
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'filter'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.users.form', [
            'user' => new User,
            'classrooms' => Classroom::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'nickname'     => ['nullable', 'string', 'max:50'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'     => ['required', 'string', 'min:8'],
            'role'         => ['required', Rule::in(['siswa', 'guru'])],
            'classroom_id' => ['nullable', 'required_if:role,siswa', 'exists:classrooms,id'],
        ]);

        $user = User::create([
            'name'         => $data['name'],
            'nickname'     => $data['nickname'] ?? null,
            'email'        => $data['email'],
            'password'     => $data['password'], // di-hash otomatis oleh cast 'hashed'
            'classroom_id' => $data['role'] === 'siswa' ? $data['classroom_id'] : null,
        ]);
        $user->assignRole($data['role']);

        return redirect()->route('admin.users.index')->with('success', 'Akun ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->authorizeAdmin();
        $this->guardAdmin($user);

        return view('admin.users.form', [
            'user' => $user,
            'classrooms' => Classroom::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeAdmin();
        $this->guardAdmin($user);

        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'nickname'     => ['nullable', 'string', 'max:50'],
            'email'        => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password'     => ['nullable', 'string', 'min:8'],
            'role'         => ['required', Rule::in(['siswa', 'guru'])],
            'classroom_id' => ['nullable', 'required_if:role,siswa', 'exists:classrooms,id'],
        ]);

        $user->fill([
            'name'         => $data['name'],
            'nickname'     => $data['nickname'] ?? null,
            'email'        => $data['email'],
            'classroom_id' => $data['role'] === 'siswa' ? $data['classroom_id'] : null,
        ]);

        if (!empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();
        $user->syncRoles([$data['role']]);

        return redirect()->route('admin.users.index', array_filter([
    'role' => $request->input('back_role'),
    'page' => $request->input('back_page'),
]))->with('success', 'Akun diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->authorizeAdmin();
        $this->guardAdmin($user);
        $user->delete();

        return back()->with('success', 'Akun dihapus.');
    }

    // Akun admin tidak boleh diubah/dihapus lewat halaman ini
    private function guardAdmin(User $user): void
    {
        abort_if($user->hasRole('admin'), 403);
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->hasRole('admin'), 403);
    }
}