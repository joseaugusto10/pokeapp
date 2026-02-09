<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function listar($perPage = 20, $pesquisa = null)
    {
        return $this->user
            ->with('roles:id,name')
            ->when($pesquisa, function ($query) use ($pesquisa) {

                $pesquisa = trim((string) $pesquisa);

                $query->where(function ($w) use ($pesquisa) {
                    $w->where('name', 'like', "%{$pesquisa}%")
                      ->orWhere('email', 'like', "%{$pesquisa}%");
                });

            })
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function buscarPorId($id)
    {
        return $this->user
            ->with('roles:id,name')
            ->find($id);
    }

    public function atualizar($userId, $dados = [])
    {
        return DB::transaction(function () use ($userId, $dados) {

            $user = $this->user->find($userId);

            if (! $user) {
                return null;
            }

            $user->update($dados);

            return $this->buscarPorId($user->id);
        });
    }

    public function definirRole($userId, $roleName)
    {
        return DB::transaction(function () use ($userId, $roleName) {

            $user = $this->user->find($userId);

            if (! $user) {
                return null;
            }

            $roleName = trim((string) $roleName);

            if (! $roleName) {
                return $this->buscarPorId($user->id);
            }

            $role = Role::where('name', $roleName)->first();

            if (! $role) {
                return $this->buscarPorId($user->id);
            }

            $user->roles()->sync([$role->id]);

            return $this->buscarPorId($user->id);
        });
    }

    public function removerPermissao($userId)
    {
        return DB::transaction(function () use ($userId) {

            $user = $this->user->find($userId);

            if (! $user) {
                return null;
            }

            $user->roles()->detach();

            return $this->buscarPorId($user->id);
        });
    }

    public function excluir($id)
    {
        return DB::transaction(function () use ($id) {

            $user = $this->user->find($id);

            if (! $user) {
                return false;
            }

            $user->roles()->detach();

            return $user->delete();
        });
    }
}
