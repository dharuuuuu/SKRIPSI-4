<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GajiPegawai;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Exports\Users_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Charts\User\JenisKelaminChart;
use App\Charts\User\UserRoleChart;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', User::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');

        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($paginate)
            ->withQueryString();

        return view('masterdata.users.index', compact('users', 'search'));
    }


    public function diagram(JenisKelaminChart $jk, UserRoleChart $role)
    {
        return view('masterdata.users.diagram', [
            'jk' => $jk->build(),
            'role' => $role->build()
        ]);
    } 


    public function create(Request $request): View
    {
        $this->authorize('create', User::class);

        $roles = Role::get();

        return view('masterdata.users.create', compact('roles'));
    }


    public function store(UserStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $user->syncRoles($request->roles);

        if ((isset($request->roles[0]) && $request->roles[0] == 2) || 
            (isset($request->roles[1]) && $request->roles[1] == 2) || 
            (isset($request->roles[2]) && $request->roles[2] == 2)) 
        {
            $gaji_pegawai = new GajiPegawai();
            $gaji_pegawai->pegawai_id = $user->id; 
            $gaji_pegawai->total_gaji_yang_bisa_diajukan = 0;  
            $gaji_pegawai->terhitung_tanggal = now();   
            $gaji_pegawai->save();
        }        

        return redirect()
            ->route('users.index', $user)
            ->withSuccess(__('crud.common.created'));
    }

    
    public function show(Request $request, User $user): View
    {
        $this->authorize('view', $user);

        return view('masterdata.users.show', compact('user'));
    }

 
    public function edit(Request $request, User $user): View
    {
        $this->authorize('update', $user);

        $roles = Role::get();

        return view('masterdata.users.edit', compact('user', 'roles'));
    }

 
    public function update(
        UserUpdateRequest $request,
        User $user
    ): RedirectResponse {
        $this->authorize('update', $user);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        $user->syncRoles($request->roles);

        $existing_gaji_pegawai = GajiPegawai::where('pegawai_id', $user->id)->first();

        $has_role_2 = false;
        foreach ($request->roles as $role) {
            if ($role == 2) {
                $has_role_2 = true;
                break;
            }
        }

        if (!$existing_gaji_pegawai) {
            if ($has_role_2) {
                $gaji_pegawai = new GajiPegawai();
                $gaji_pegawai->pegawai_id = $user->id; 
                $gaji_pegawai->total_gaji_yang_bisa_diajukan = 0; 
                $gaji_pegawai->terhitung_tanggal = now();  
                $gaji_pegawai->save();
            }
        } 
        
        elseif ($existing_gaji_pegawai) {
            $has_role_not_2 = true;
            foreach ($request->roles as $role) {
                if ($role == 2) {
                    $has_role_not_2 = false;
                    break;
                }
            }

            if ($has_role_not_2) {
                $existing_gaji_pegawai->delete();
            }
        }

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.saved'));
    }

  
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export_excel()
    {
        return Excel::download(new Users_Export_Excel, 'Users - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $users = User::all();

        $pdf = PDF::loadView('PDF.users', compact('users'))->setPaper('a4', 'landscape');;

        return $pdf->download('Users - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
