<?php

namespace App\Filament\Resources\EvaluationResource\Pages;

use Filament\Actions;
use App\Models\Criteria;
use App\Models\Evaluation;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EvaluationResource;

class EditEvaluation extends EditRecord
{
    protected static string $resource = EvaluationResource::class;



    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // 1. Hitung total_score
        $totalScore = 0;
        $criteriaValues = $data['criteria_values'] ?? [];

        foreach ($criteriaValues as $criteriaId => $value) {
            $criteria = Criteria::find($criteriaId);
            if ($criteria) {
                $bobot = $criteria->bobot ?? 100;
                $totalScore += $value * ($bobot / 100);
            }
        }

        // 2. Tentukan description otomatis
        if ($totalScore >= 90) {
            $description = 'Sangat Baik';
        } elseif ($totalScore >= 75) {
            $description = 'Baik';
        } elseif ($totalScore >= 60) {
            $description = 'Cukup';
        } else {
            $description = 'Kurang';
        }

        // 3. Update record evaluation
        $record->update([
            'user_id' => $data['user_id'],
            'total_score' => $totalScore,
            'description' => $description,
        ]);

        // 4. Update evaluation_details
        foreach ($criteriaValues as $criteriaId => $value) {
            // Jika detail sudah ada, update; jika tidak ada, buat baru
            $record->details()->updateOrCreate(
                ['criteria_id' => $criteriaId],
                ['value' => $value]
            );
        }

        return $record;
    }

    protected function fillForm(): void
    {
        if ($this->record) {
            // Ambil data dari evaluation
            $formData = [
                'user_id' => $this->record->user_id,
                'total_score' => $this->record->total_score,
                'description' => $this->record->description,
            ];

            // Ambil semua evaluation_details
            foreach ($this->record->details as $detail) {
                $formData['criteria_values'][$detail->criteria_id] = $detail->value;
            }

            // Isi form
            $this->form->fill($formData);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
