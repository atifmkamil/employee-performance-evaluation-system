<?php

namespace App\Filament\Resources\EvaluationResource\Pages;

use Filament\Actions;
use App\Models\Criteria;
use App\Models\Evaluation;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\EvaluationResource;

class CreateEvaluation extends CreateRecord
{
    protected static string $resource = EvaluationResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
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

        // 3. Simpan record evaluation
        $evaluation = Evaluation::create([
            'user_id' => $data['user_id'],
            'total_score' => $totalScore,
            'description' => $description,
        ]);

        // 4. Simpan evaluation_details
        foreach ($criteriaValues as $criteriaId => $value) {
            $evaluation->details()->create([
                'criteria_id' => $criteriaId,
                'value' => $value,
            ]);
        }

        return $evaluation;
    }

    // protected function afterCreate(\App\Models\Evaluation $record): void
    // {
    //     logger($this->form->getState()['criteria_values'] ?? []);
    //     $criteriaValues = $this->form->getState()['criteria_values'] ?? [];
    //     $totalScore = 0;


    //     foreach ($criteriaValues as $criteriaId => $value) {
    //         $criteria = \App\Models\Criteria::find($criteriaId);

    //         $weightedValue = $value * ($criteria->bobot / 100);

    //         $record->details()->create([
    //             'criteria_id' => $criteriaId,
    //             'value' => $value,
    //         ]);

    //         $totalScore += $weightedValue;
    //     }

    //     // Tentukan description berdasarkan total_score
    //     if ($totalScore >= 90) {
    //         $description = 'Sangat Baik';
    //     } elseif ($totalScore >= 75) {
    //         $description = 'Baik';
    //     } elseif ($totalScore >= 60) {
    //         $description = 'Cukup';
    //     } else {
    //         $description = 'Kurang';
    //     }

    //     // Update total_score dan description di evaluations
    //     $record->update([
    //         'total_score' => $totalScore,
    //         'description' => $description,
    //     ]);
    // }

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // Hitung total_score & set description sebelum disimpan
    //     $totalScore = 0;
    //     if (isset($data['criteria_values'])) {
    //         foreach ($data['criteria_values'] as $criteriaId => $value) {
    //             $criteria = \App\Models\Criteria::find($criteriaId);
    //             if ($criteria) {
    //                 $weight = $criteria->weight ?? 100;
    //                 $totalScore += $value * ($weight / 100);
    //             }
    //         }
    //     }

    //     $data['total_score'] = $totalScore;
    //     logger($data);

    //     if ($totalScore >= 90) $data['description'] = 'Sangat Baik';
    //     elseif ($totalScore >= 75) $data['description'] = 'Baik';
    //     elseif ($totalScore >= 60) $data['description'] = 'Cukup';
    //     else $data['description'] = 'Kurang';

    //     return $data;
    // }

    // protected function afterCreate(\App\Models\Evaluation $record): void
    // {
    //     $criteriaValues = $this->form->getState()['criteria_values'] ?? [];

    //     foreach ($criteriaValues as $criteriaId => $value) {
    //         $criteria = \App\Models\Criteria::find($criteriaId);
    //         if (!$criteria) continue;

    //         $record->details()->create([
    //             'criteria_id' => $criteriaId,
    //             'value' => $value,
    //         ]);
    //     }
    // }
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // Hitung total_score dulu
    //     $totalScore = 0;

    //     // $data['criteria_values'] =
    //     //     [
    //     //         1 => 90,
    //     //         2 => 90,
    //     //         3 => 90,
    //     //         4 => 90,
    //     //         5 => 90
    //     //     ];

    //     if (!empty($data['criteria_values']) && is_array($data['criteria_values'])) {
    //         foreach ($data['criteria_values'] as $criteriaId => $value) {
    //             $criteria = Criteria::find($criteriaId);

    //             // dump($criteria);
    //             if ($criteria) {
    //                 $bobot = $criteria->bobot ?? 100;
    //                 $totalScore += $value * ($bobot / 100);
    //             }
    //         }
    //     }

    //     // dd($data['criteria_values'], is_array($data['criteria_values']));

    //     // Tentukan description otomatis
    //     if ($totalScore >= 90) {
    //         $description = 'Sangat Baik';
    //     } elseif ($totalScore >= 75) {
    //         $description = 'Baik';
    //     } elseif ($totalScore >= 60) {
    //         $description = 'Cukup';
    //     } else {
    //         $description = 'Kurang';
    //     }

    //     $data['total_score'] = $totalScore;
    //     $data['description'] = $description;
    //     // dd($data);
    //     unset($data['criteria_values']);

    //     return $data;
    // }
    // private array $criteriaValues = [];

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     if (!empty($data['criteria_values']) && is_array($data['criteria_values'])) {
    //         // simpan ke properti kelas
    //         $this->criteriaValues = $data['criteria_values'];

    //         $totalScore = 0;
    //         foreach ($data['criteria_values'] as $criteriaId => $value) {
    //             $criteria = Criteria::find($criteriaId);
    //             if ($criteria) {
    //                 $bobot = $criteria->bobot ?? 100;
    //                 $totalScore += $value * ($bobot / 100);
    //             }
    //         }

    //         // Tentukan description otomatis
    //         if ($totalScore >= 90) {
    //             $description = 'Sangat Baik';
    //         } elseif ($totalScore >= 75) {
    //             $description = 'Baik';
    //         } elseif ($totalScore >= 60) {
    //             $description = 'Cukup';
    //         } else {
    //             $description = 'Kurang';
    //         }

    //         $data['total_score'] = (string) $totalScore;
    //         $data['description'] = $description;

    //         // hapus dari data agar tidak error
    //         unset($data['criteria_values']);
    //     }
    //     // dump($this->criteriaValues);
    //     return $data;
    // }

    // protected function mutateFormDataAfterCreate(Evaluation $record): void
    // {
    //     dump($this->criteriaValues);
    // try {
    //     // kode Anda
    //     dump($this->criteriaValues);
    // } catch (\Throwable $e) {
    //     dd($e->getMessage(), $e->getTraceAsString());
    // }
    // foreach ($this->criteriaValues as $criteriaId => $value) {
    //     $record->details()->create([
    //         'criteria_id' => $criteriaId,
    //         'value' => $value,
    //     ]);
    // }
    // dump($criteriaValues);
    // }
    // protected function afterCreate(Evaluation $record): void
    // {
    //     $criteriaValues = $this->form->getState()['criteria_values'] ?? [];



    //     foreach ($criteriaValues as $criteriaId => $value) {
    //         // Di sini evaluation_id otomatis diisi dari $record->id
    //         $record->details()->create([
    //             // 'evaluation_id' => '1',
    //             'criteria_id' => $criteriaId,
    //             'value' => $value,
    //         ]);
    //     }
    // }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
