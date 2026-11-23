<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\Mission;
use Illuminate\Database\Seeder;

class MissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('adventure.missions') as $missionData) {
            $challengeData = $missionData['challenges'];
            unset($missionData['challenges']);

            $missionAttributes = $missionData + ['is_active' => true];
            $mission = Mission::firstOrCreate(
                ['slug' => $missionAttributes['slug']],
                $missionAttributes,
            );

            foreach ($challengeData as $challengeAttributes) {
                $options = $challengeAttributes['options'];
                unset($challengeAttributes['options']);

                $challengeAttributes['is_active'] = true;
                $challenge = Challenge::firstOrCreate(
                    [
                        'mission_id' => $mission->id,
                        'level' => $challengeAttributes['level'],
                        'position' => $challengeAttributes['position'],
                    ],
                    $challengeAttributes,
                );

                foreach ($options as $optionData) {
                    $optionPosition = $optionData['position'];
                    unset($optionData['position']);

                    $challenge->options()->firstOrCreate(
                        ['position' => $optionPosition],
                        $optionData,
                    );
                }
            }
        }
    }
}
