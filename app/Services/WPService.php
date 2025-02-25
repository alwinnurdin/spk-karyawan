<?php

namespace App\Services;

use App\Models\User;
use App\Models\Criteria;
use App\Models\Score;
use Illuminate\Support\Facades\DB;

class WPService
{
    /**
     * Get decision matrix from scores table
     */
    private function getDecisionMatrix()
    {
        try {
            $matrix = [];
            $alternatives = User::all();
            $criterias = Criteria::all();
            
            // Get all scores efficiently
            $scores = Score::all()->groupBy(['alternative_id', 'criteria_id']);

            foreach ($alternatives as $alternative) {
                foreach ($criterias as $criteria) {
                    $score = $scores[$alternative->id][$criteria->id] ?? null;
                    $matrix[$alternative->id][$criteria->id] = $score ? $score->first()->value : 0;
                }
            }

            return [
                'success' => true,
                'data' => $matrix,
                'criterias' => $criterias
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error getting decision matrix: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Calculate S vector (preferences for each alternative)
     */
    private function calculateSVector($matrix, $criterias)
    {
        $sVector = [];

        foreach ($matrix as $altId => $scores) {
            $sVector[$altId] = 1; // Initialize multiplication
            
            foreach ($scores as $critId => $score) {
                $criteria = $criterias->firstWhere('id', $critId);
                $weight = $criteria->weight / 100; // Convert percentage to decimal
                
                // Adjust weight based on criteria attribute (benefit/cost)
                if ($criteria->attribute === 'cost') {
                    $weight = -$weight; // Negative weight for cost criteria
                }
                
                // Calculate S vector using power
                $sVector[$altId] *= pow($score ?: 1, $weight);
            }
        }

        return $sVector;
    }

    /**
     * Calculate V vector (relative preferences)
     */
    private function calculateVVector($sVector)
    {
        $sumS = array_sum($sVector);
        $vVector = [];

        foreach ($sVector as $altId => $s) {
            $vVector[$altId] = $sumS != 0 ? $s / $sumS : 0;
        }

        return $vVector;
    }

    /**
     * Calculate final ranking using Weighted Product Method
     */
    public function calculateRanking()
    {
        try {
            // Get decision matrix
            $matrixResult = $this->getDecisionMatrix();
            if (!$matrixResult['success']) {
                throw new \Exception($matrixResult['message']);
            }

            $matrix = $matrixResult['data'];
            $criterias = $matrixResult['criterias'];
            $alternatives = User::all();

            // Calculate S Vector
            $sVector = $this->calculateSVector($matrix, $criterias);

            // Calculate V Vector
            $vVector = $this->calculateVVector($sVector);

            // Prepare ranking results
            $finalScores = [];
            foreach ($vVector as $altId => $score) {
                $alternative = $alternatives->firstWhere('id', $altId);
                $finalScores[] = [
                    'id' => $altId,
                    'name' => $alternative->name,
                    'score' => $score,
                    's_value' => $sVector[$altId],
                    'v_value' => $score,
                    'criteria_scores' => $matrix[$altId]
                ];
            }

            // Sort by V value (score) descending
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
                    'matrix' => $matrix,
                    's_vector' => $sVector,
                    'v_vector' => $vVector,
                    'ranking' => $finalScores
                ]
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error calculating WP ranking: ' . $e->getMessage()
            ];
        }
    }
}