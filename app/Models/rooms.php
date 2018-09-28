<?php

namespace Svityaz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class rooms extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    static function list($page, $hotel_id, $filter = false){
        $num = 5;
        $c = \DB::select('select count(id) as c from rooms where hotel_id='.$hotel_id);
        $count = $c[0]->c;//всего позиций
        $pages = ceil($count / $num);//всего страниц
        $pagg ='<ul class="pagg" id="room_pagg">';
        if ($page == 1){
            $pagg .= '<li class="disabled"><a href="#" id="prev_room"><</a></li>';
        } else {
            $pagg .= '<li><a href="#" id="prev_room"><</a></li>';
        }
        switch ($pages){
            case 1:
                $pagg .= '<li><a href="#">1</a></li>';
                break;
            case 2:
                $pagg .= '<li><a href="#">1</a></li>';
                $pagg .= '<li><a href="#">2</a></li>';
                break;
            default:
                if ($page == 1){
                    $a1 = 1;
                    $a2 = 2;
                    $a3 = 3;
                } elseif ($page == $pages) {
                    $a1 = $page-2;
                    $a2 = $page-1;
                    $a3 = $page;
                } else {
                    $a1 = $page-1;
                    $a2 = $page;
                    $a3 = $page+1;
                }
                $pagg .= '<li><a href="#">'.$a1.'</a></li>';
                $pagg .= '<li><a href="#">'.$a2.'</a></li>';
                $pagg .= '<li><a href="#">'.$a3.'</a></li>';
                break;
        }
        if ($page == $pages){
            $pagg .= '<li class="disabled"><a href="#" id="next_room">></a></li>';
        } else {
            $pagg .= '<li><a href="#" id="next_room">></a></li>';
        }
        $list = \DB::select('select * from rooms
                where hotel_id='.$hotel_id.' limit ' . (($page - 1) * $num) . ',' . $num);
        $data = ['list'=>$list, 'pagg'=>$pagg];
        return $data;
    }
}
