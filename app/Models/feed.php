<?php

namespace Svityaz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;

class feed extends Model
{
    use SoftDeletes;
    static function list($page, $filter = false)
    {
        $now = Date('Y-m-d H:i:s', time());
        $fil = '';
        $ord = '';
        if ($filter){
            $fil = ' and (hotels.title like "%'.$filter.'%" or users.name like "%'.$filter.'%" or feeds.name like "%'.$filter.'%") ';
            log::info('fil='.$fil);
        }
        $num = 5;
        $c_sel = 'select count(feeds.id) as c from feeds where feeds.id in (select feeds.id from feeds, hotels, users where feeds.deleted_at IS NULL and feeds.hotel_id=hotels.id and hotels.user_id=users.id '.$fil.')';
        log::info('select='.$c_sel);
        $c = \DB::select($c_sel);
        $count = $c[0]->c;//всего позиций
        $pages = ceil($count / $num);//всего страниц
        $pagg ='<ul class="pagination text-center" id="feed_pagg">';
        if ($page == 1){
            $pagg .= '<li class="disabled"><a href="#" id="prev_feed"><</a></li>';
        } else {
            $pagg .= '<li><a href="#" id="prev_feed"><</a></li>';
        }
        switch ($pages){
            case 0:
                $pagg .= '<li><a href="#">1</a></li>';
                break;
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
            $pagg .= '<li class="disabled"><a href="#" id="next_feed">></a></li>';
        } else {
            $pagg .= '<li><a href="#" id="next_feed">></a></li>';
        }
        $s = 'select DISTINCT feeds.id as f_id from feeds, hotels, users';
        $s .= ' where feeds.deleted_at IS NULL and feeds.hotel_id=hotels.id and hotels.user_id=users.id '.$fil;
        $row = \DB::select($s);
        $imp ='';
        foreach ($row as $r) {
            if ($imp!=''){
                $imp .= ',';
            }
            $imp .= $r->f_id;
        }
        if ($imp==''){
            $imp = 0;
        }
        Log::info(' all feeds='.$imp);
        Log::info(' fil='.$fil);
        $sel = 'select feeds.id, hotels.title, users.name as owner_name, feeds.comment, feeds.phone as author_phone,
        feeds.name as author_name, feeds.status, feeds.reight, users.id as user_id
        from hotels, users, feeds';
        $sel .= ' where feeds.hotel_id=hotels.id and hotels.user_id=users.id and feeds.id in ('.$imp.')';
        $sel .= ' order by feeds.status ASC ';
        $sel .= $ord.' limit ' . (($page - 1) * $num) . ',' .$num;
        $list = \DB::select($sel);
        for ($i=0; $i < count($list); $i++) {
            $phone = phone::where('user_id','=',$list[$i]->user_id)->orderBy('id', 'asc')->first();
            $list[$i]->phone= $phone->phone;
        }
        $data = ['list'=>$list, 'pagg'=>$pagg,'count'=>$count];
        return $data;
    }
}
