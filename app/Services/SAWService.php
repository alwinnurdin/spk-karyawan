<?php

namespace App\Services;

use App\Models\User;
use App\Models\Criteria;
use App\Models\Score;
use Illuminate\Support\Facades\DB;

class SawService
{
    /**
     * Get decision matrix from scores table
     */
    public function getDecisionMatrix()
    {
        try {
            $matrix = [];
            $alternatives = User::all();
            $criterias = Criteria::all();
            
            // Get all scores at once to avoid N+1 queries
            $scores = Score::all()->groupBy(['alternative_id', 'criteria_id']);

            foreach ($alternatives as $alternative) {
                foreach ($criterias as $criteria) {
                    $score = $scores[$alternative->id][$criteria->id] ?? null;
                    $matrix[$alternative->id][$criteria->id] = $score ? $score->first()->value : 0;
                }
            }

            return [
                'success' => true,
                'data' => $matrix
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error getting decision matrix: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Calculate normalization matrix
     */
    public function calculateNormalization()
    {
        try {
            $matrixResult = $this->getDecisionMatrix();
            if (!$matrixResult['success']) {
                throw new \Exception($matrixResult['message']);
            }

            $matrix = $matrixResult['data'];
            $criterias = Criteria::all();
            $normalization = [];

            foreach ($criterias as $criteria) {
                $values = array_column($matrix, $criteria->id);
                
                // Skip if no values
                if (empty($values)) continue;

                foreach ($matrix as $altId => $scores) {
                    if ($criteria->attribute === 'benefit') {
                        $max = max($values) ?: 1;
                        $normalization[$altId][$criteria->id] = 
                            $matrix[$altId][$criteria->id] / $max;
                    } else { // cost
                        $min = min($values) ?: 1;
                        $normalization[$altId][$criteria->id] = 
                            $min / ($matrix[$altId][$criteria->id] ?: 1);
                    }
                }
            }

            return [
                'success' => true,
                'data' => [
                    'matrix' => $matrix,
                    'normalization' => $normalization
                ]
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error calculating normalization: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Calculate weighted scores
     */
    public function calculateWeightedScores(array $normalization)
    {
        try {
            $criterias = Criteria::all();
            $weighted = [];

            foreach ($normalization as $altId => $scores) {
                foreach ($scores as $critId => $score) {
                    $criteria = $criterias->firstWhere('id', $critId);
                    $weighted[$altId][$critId] = $score * ($criteria->weight / 100);
                }
            }

            return [
                'success' => true,
                'data' => $weighted
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error calculating weighted scores: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Calculate final ranking
     */
    public function calculateRanking()
    {
        try {
            // Get normalized matrix
            $normalizedResult = $this->calculateNormalization();
            if (!$normalizedResult['success']) {
                throw new \Exception($normalizedResult['message']);
            }

            // Calculate weighted scores
            $weightedResult = $this->calculateWeightedScores(
                $normalizedResult['data']['normalization']
            );
            if (!$weightedResult['success']) {
                throw new \Exception($weightedResult['message']);
            }

            // Calculate final scores
            $alternatives = User::all();
            $weightedScores = $weightedResult['data'];
            $finalScores = [];

            foreach ($weightedScores as $altId => $scores) {
                $alternative = $alternatives->firstWhere('id', $altId);
                $finalScores[] = [
                    'id' => $altId,
                    'name' => $alternative->name,
                    'score' => array_sum($scores),
                    'details' => $scores
                ];
            }

            // Sort by score descending
            usort($finalScores, function($a, $b) {
                return $b['score'] <=> $a['score'];
            });

            // Add ranking
            $rank = 1;
            foreach ($finalScores as &$score) {
                $score['rank'] = $rank++;
            }

            return [
                'success' => true,
                'data' => [
                    'matrix' => $normalizedResult['data']['matrix'],
                    'normalization' => $normalizedResult['data']['normalization'],
                    'weighted' => $weightedResult['data'],
                    'ranking' => $finalScores
                ]
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error calculating ranking: ' . $e->getMessage()
            ];
        }
    }
}
