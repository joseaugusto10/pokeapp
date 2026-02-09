<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function listar($perPage = 20, $pesquisa = null)
    {
        try {
            return $this->userRepository->listar($perPage, $pesquisa);
        } catch (Exception $e) {
            throw new Exception('Não foi possível listar usuários agora.');
        }
    }

    public function buscarPorId($id)
    {
        try {
            if (! $id) {
                throw new Exception('Usuário inválido.');
            }

            return $this->userRepository->buscarPorId($id);

        } catch (Exception $e) {
            throw new Exception('Não foi possível buscar o usuário.');
        }
    }

    public function atualizar($userId, $dados = [])
    {
        try {
            if (! $userId) {
                throw new Exception('Usuário inválido.');
            }

            if (empty($dados)) {
                throw new Exception('Nenhum dado para atualizar.');
            }

            return $this->userRepository->atualizar($userId, $dados);

        } catch (Exception $e) {
            throw new Exception($e->getMessage() ?: 'Erro ao atualizar usuário.');
        }
    }

    public function definirRole($userId, $roleName)
    {
        try {
            if (! $userId || ! $roleName) {
                throw new Exception('Dados inválidos para definir permissão.');
            }

            return $this->userRepository->definirRole($userId, $roleName);

        } catch (Exception $e) {
            throw new Exception($e->getMessage() ?: 'Erro ao definir permissão.');
        }
    }

    public function removerPermissao($userId)
    {
        try {
            if (! $userId) {
                throw new Exception('Usuário inválido.');
            }

            return $this->userRepository->removerPermissao($userId);

        } catch (Exception $e) {
            throw new Exception('Não foi possível remover a permissão.');
        }
    }

    public function excluir($userId)
    {
        try {
            if (! $userId) {
                throw new Exception('Usuário inválido.');
            }

            return $this->userRepository->excluir($userId);

        } catch (Exception $e) {
            throw new Exception('Não foi possível excluir o usuário.');
        }
    }
}
