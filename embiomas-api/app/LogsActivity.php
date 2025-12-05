<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Boot the trait.
     * Isso registra os "ouvintes" de eventos do model.
     */
    protected static function bootLogsActivity()
    {
        // Evento "created": dispara DEPOIS que um novo registro é salvo
        static::created(function (Model $model) {
            self::logActivity($model, 'criacao', null);
        });

        // Evento "updated": dispara DEPOIS que um registro é atualizado
        static::updated(function (Model $model) {
            $dirty = $model->getDirty(); // Pega os campos que foram alterados
            unset($dirty['updated_at']); // Remove o timestamp da lista

            // Só registra o log se algo realmente mudou
            if (!empty($dirty)) {
                self::logActivity($model, 'edicao', $dirty);
            }
        });

        // Evento "deleted": dispara DEPOIS que um registro é deletado
        static::deleted(function (Model $model) {
            self::logActivity($model, 'exclusao', null);
        });
    }

    /**
     * Função auxiliar para pegar o nome do objeto.
     */
    protected static function getModelName(Model $model): string
    {
        // Lista de campos de nome comuns em ordem de prioridade
        $nameFields = [
            'nome_bioma', 'nome_fauna', 'nome_flora', 'nome_relevo',
            'nome_hidrografia', 'nome_clima', 'nome_cse', 'nome_ap',
            'name', // Para o model User
            'titulo_post' // Para o model Post
        ];

        foreach ($nameFields as $field) {
            if (isset($model->{$field})) {
                return $model->{$field};
            }
        }

        // Fallback se nenhum campo de nome for encontrado
        return class_basename($model) . ' #' . $model->getKey();
    }

    /**
     * Gera a string de detalhes para o log, como você solicitou.
     */
    protected static function generateLogDetails(Model $model, string $tipoAlteracao, ?array $dirtyFields): string
    {
        $objectType = class_basename($model); // Ex: "Relevo"
        $objectName = self::getModelName($model); // Ex: "Depressão"

        switch ($tipoAlteracao) {
            case 'criacao':
                $detail = "{$objectType} criado: {$objectName}";
                // Tenta adicionar o bioma, se for um item relacionado
                if (isset($model->bioma_id) && $model->bioma) {
                    $detail .= " (Bioma: " . $model->bioma->nome_bioma . ")";
                }
                return $detail;

            case 'edicao':
                // Converte 'descricao_fauna' para 'Descricao fauna'
                $camposAlterados = array_map(function ($field) {
                    return ucfirst(str_replace('_', ' ', $field));
                }, array_keys($dirtyFields));

                return "Campos alterados: " . implode(', ', $camposAlterados);

            case 'exclusao':
                return "{$objectType} excluído: {$objectName}";
        }
        return 'Ação desconhecida';
    }

    /**
     * A função principal que salva o log no banco de dados.
     */
    protected static function logActivity(Model $model, string $tipoAlteracao, ?array $dirtyFields = null)
    {
        $objectName = self::getModelName($model);
        $detalhes = self::generateLogDetails($model, $tipoAlteracao, $dirtyFields);

        // Use o relacionamento 'historico' que definimos no model
        $model->historico()->create([
            'user_id' => Auth::id() ?? 1, // Usa 1 (Admin do Sistema) como fallback para seeders
            'tipo_alteracao' => $tipoAlteracao,
            'nome_objeto' => $objectName, // Salva o novo campo de nome
            'detalhes_alteracao' => $detalhes, // Salva os novos detalhes
        ]);
    }
}
