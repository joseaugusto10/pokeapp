<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRoleRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 20);
            $pesquisa = $request->query('pesquisa');

            if ($perPage <= 0) {
                $perPage = 20;
            }

            $lista = $this->userService->listar($perPage, $pesquisa);

            return view('usuarios.index', [
                'lista' => $lista,
                'pesquisa' => $pesquisa,
                'perPage' => $perPage,
            ]);
        } catch (Exception $e) {
            return back()->with('erro', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $user = $this->userService->buscarPorId($id);

            if (! $user) {
                return redirect()->route('usuarios.index')->with('erro', 'Usuário não encontrado.');
            }

            return view('usuarios.edit', [
                'user' => $user,
            ]);
        } catch (Exception $e) {
            return redirect()->route('usuarios.index')->with('erro', $e->getMessage());
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        try {
            $dados = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ];

            $user = $this->userService->atualizar($id, $dados);

            if (! $user) {
                return back()->with('erro', 'Usuário não encontrado.');
            }

            return redirect()
                ->route('usuarios.edit', ['id' => $id])
                ->with('success', 'Usuário atualizado com sucesso!');
        } catch (Exception $e) {
            return back()->with('erro', $e->getMessage());
        }
    }

    public function definirRole(UserRoleRequest $request, $id)
    {
        try {
            $role = $request->input('role');

            $user = $this->userService->definirRole($id, $role);

            if (! $user) {
                return back()->with('erro', 'Usuário não encontrado.');
            }

            return back()->with('success', 'Permissão atualizada com sucesso!');
        } catch (Exception $e) {
            return back()->with('erro', $e->getMessage());
        }
    }

    public function removerPermissao($id)
    {
        try {
            $user = $this->userService->removerPermissao($id);

            if (! $user) {
                return back()->with('erro', 'Usuário não encontrado.');
            }

            return back()->with('success', 'Permissão removida. Esse usuário não acessa mais o sistema.');
        } catch (Exception $e) {
            return back()->with('erro', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $ok = $this->userService->excluir($id);

            if (! $ok) {
                return back()->with('erro', 'Usuário não encontrado.');
            }

            return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso!');
        } catch (Exception $e) {
            return back()->with('erro', 'Não foi possível excluir agora.');
        }
    }
}
