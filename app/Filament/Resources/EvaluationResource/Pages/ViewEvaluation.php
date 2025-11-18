<?php

namespace App\Filament\Resources\EvaluationResource\Pages;

use App\Filament\Resources\EvaluationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEvaluation extends ViewRecord
{
    protected static string $resource = EvaluationResource::class;

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
            Actions\EditAction::make(),
        ];
    }
}
