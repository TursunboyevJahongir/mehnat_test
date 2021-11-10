<?php


namespace App\Services;

use App\Models\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PositionService
{
    /**
     * @param array $data
     * @return Builder|Model|Position
     */
    public function create(array $data): Model|Builder|Position
    {
        return Position::create([
            'name' => [
                'uz' => $data['name_uz'],
                'ru' => $data['name_ru'],
                'en' => $data['name_en']
            ],
            'details' => [
                'uz' => $data['details_uz'] ?? null,
                'ru' => $data['details_ru'] ?? null,
                'en' => $data['details_en'] ?? null
            ]
        ]);
    }

    /**
     * @param Position $id
     * @param array $data
     * @return Model|null
     */
    public function update(Position $id, array $data): Model|null
    {
        $id->update([
            'name' => [
                'uz' => $data['name_uz'],
                'ru' => $data['name_ru'],
                'en' => $data['name_en']
            ],
            'details' => [
                'uz' => $data['details_uz'] ?? $id->details_uz,
                'ru' => $data['details_ru'] ?? $id->details_ru,
                'en' => $data['details_en'] ?? $id->details_en
            ],
        ]);

        return $id;
    }

    /**
     * @param Position $id
     * @return bool
     */
    public function delete(Position $id): bool
    {
        $id->delete();
        return true;
    }
}
