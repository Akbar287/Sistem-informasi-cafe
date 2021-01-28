<?php

namespace App\Helper;

use App\StockCards;
use App\StockOpname;

class CodeMaker {
    public static function codeMaker($type, $name){
        $from = date('Y-') . '01-01';$till = date('Y-') . '12-31';
        $lastCode = StockCards::select('stock_cards.code_id')->where('type_stock.name', $name)->join('type_stock', 'type_stock.type_stock_id', 'stock_cards.type_stock_id')->whereBetween('stock_cards.created_at', [$from, $till])->orderBy('stock_cards.code_id', 'desc')->first();
        $matches = '';
        if(is_null($lastCode)) {
            $matches = $type . '-' . date('Y') . '0000001';
        } else {
            preg_match_all('!\d+!', $lastCode->code_id, $matches);
            $matches = strval(intval(explode(date('Y'), $matches['0']['0'])['1']) + 1);
            $cond = 7 - strlen($matches);
            $zero="";
            for($i=0; $i < $cond; $i++) {
                $zero .= "0";
            }
            $matches = $type . '-' . date('Y'). $zero . $matches;
        }
        return ($matches); exit;
    }
    public static function StockOpname($type, $name) {
        $from = date('Y-') . '01-01';$till = date('Y-') . '12-31';
        $lastCode = StockOpname::select('code_id')->whereBetween('created_at', [$from, $till])->orderBy('code_id', 'desc')->first();
        $matches = '';
        if(is_null($lastCode)) {
            $matches = $type . '-' . date('Y') . '0000001';
        } else {
            preg_match_all('!\d+!', $lastCode->code_id, $matches);
            $matches = strval(intval(explode(date('Y'), $matches['0']['0'])['1']) + 1);
            $cond = 7 - (strlen($matches));$zero="";
            for($i=0; $i < $cond; $i++) {
                $zero .= "0";
            }
            $matches = $type . '-' . date('Y'). $zero . $matches;
        }
        return ($matches); exit;
    }
}
