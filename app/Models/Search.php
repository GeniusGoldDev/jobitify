<?php

namespace App\Models;

trait Search
{
    private function buildWildCards( $search_term ) {

        if ( $search_term == "" ) {
            return $search_term;
        }
        
        // remove MySQL reserved words
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $search_term = str_replace($reservedSymbols, '', $search_term);

        $words = explode(' ', $search_term);
        $words = array_filter(array_map('trim', $words), function($val) {
            return $val !== '';
        });
        foreach($words as $idex => $word) {
            // fulltext indices.
            $words[$idex] = "+" . $word . "*";
        }
        $search_term = implode(' ', $words);
        return $search_term;
    }

    protected function scopeSearch($query, $search_term) {
        if( !empty($search_term) ){
            $columns = implode(',', $this->searchable);
            $query->whereRaw(
                "MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)",
                $this->buildWildCards($search_term)
            );
        }
        return $query;
    }
}