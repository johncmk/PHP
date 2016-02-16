<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Auth;
/*
 * Post CRUD
 */
class PostController extends Controller
{
	/*
	*
	*/
    public function write(Request $request) {

    	if(!$request->ajax()) {
    		return response()->json(["msg" => "Ajax Failed Error !"]);
    	}

    	$title =  $request->input('title');
    	$comment = $request->input('comment');

    	//This is using PDO
    	$param_arr = array("title" => $title, "comment" => $comment, "user_id" => Auth::user()->id, "username" =>Auth::user()->name);
    	
    	$query = "INSERT INTO one_post(title, comment, user_id, username) VALUES(:title, :comment, :user_id, :username)";


    	$ret  = DB::insert($query,$param_arr);

    	if(!$ret) {
    		return response()->json(["msg" => "Insert failed, Please contact to owner."]);
    	}

        $ret = DB::select('SELECT LAST_INSERT_ID() as last_id');

        if(isset($ret)) {
            $ret = $ret[0];
        }

    	return response()->json([
    								"msg" => "",
                                    "rs" => $ret
    											 ]);
    }

    //Implement Pagination
    public function search(Request $request) {

        $title = $request->input('title');
        $current_page = $request->input('current_page',1);
        $rows = 0;

        $query = "select count(p_id) cnt from one_post where 1 = 1 ";

        if(!empty($title)) {
            $query .= " AND title like :title";
            $rows = DB::select($query,array('title' => '%'.$title.'%'));
        }else {
            $rows = DB::select($query);
        }


        if(count($rows) < 1) {
            $msg = "Total rows error !";
        }

        $range = 3;
        $total_rows = $rows[0]->cnt;
        $rows_per_page = 10;
        $total_pages = ceil($total_rows/$rows_per_page);

        if( !is_numeric($current_page)) {
            $current_page = 1;
        }

        if( $current_page > $total_pages) {
            $current_page = $total_pages; //set the current page to the last
        }else if( $current_page < 1) {
            $current_page = 1;
        }

        $offset = ($current_page - 1) * $rows_per_page;

        if($offset < 0) {
            $offset = 0;
        }

        $query = "select 
                     p_id,
                     title, 
                     user_id,
                     username,
                     edate 
                 from 
                     one_post 
                    where 
                        1=1 ";   
        
        $param_arr = array();
        
        if(!empty($title)) {
            $query .= " AND title like :title ";
            $param_arr = array_merge($param_arr, array('title' => '%'.$title.'%'));
        }

        $query .=" order by edate desc ";
        $query .= " LIMIT ".$offset.",". $rows_per_page;

        $RS = DB::select($query, $param_arr);

        if(count($RS) < 1) {
            // return response()->json(["msg" => "There isn't any data..."]);
            $msg = "There aren't any data.";
        }

        $username = (Auth::user() != null)? Auth::user()->name : "Anonymous";
        
        return view('pages.post',compact(
                                        'title',
                                        'total_rows',
                                        'range',
                                        'username',
                                        'rows_per_page',
                                        'total_pages',
                                        'current_page',
                                        'RS'
                                                        ));
    }




    public function remove_post(Request $request) {
    	if(!$request->ajax()) {
    		return response()->json(["msg" => "Ajax Failed... "]);
    	}

    	$p_id = $request->input('p_id');

    	$query = "delete from one_post where p_id = :p_id";

    	$param_arr = array();
    	if(!empty($p_id)) {
    		$param_arr = compact('p_id');
    	}

    	$ret = DB::delete($query, $param_arr);

    	if( !$ret ) {
    		return response()->json(["msg" => "delete failed..."]);
    	}

    	return response()->json(['msg' => ""]);

    }

    public function edit(Request $request) {
    	if(!$request->ajax()) {
    		return response()->json(["msg" => "Ajax Failed... "]);
    	}

    	$p_id = $request->input('p_id');
    	$title = $request->input('title');
    	$comment = $request->input('comment');

    	$query = "update one_post
					set title = :title,
						comment = :comment,
						edate = NOW()
					where 
						p_id = :p_id";

		$param_arr = array();
		if(!empty($p_id)) {
			$param_arr = compact('p_id');
		}

		if(!empty($title)) {
			$param_arr = array_merge($param_arr,compact('title'));
		}

		if(!empty($comment)) {
			$param_arr = array_merge($param_arr,compact('comment'));
		}

		$ret = DB::update($query,$param_arr);

		if(!$ret) {
			return response()->json(["msg" => "Edit failed...."]);
		}

		return response()->json([
								"msg" => ""
                                            ]);
    }

    public function show_detail(Request $request) {
    	if(!$request->ajax()) {
    		return response()->json(["msg" => "Ajax Failed... "]);
    	}

    	$p_id = $request->input('p_id');

    	$query = "Select * from one_post";

    	$param_arr = array();
    	
    	if(!empty($p_id)) {
    		$query .= " where p_id = :p_id";
    		$param_arr = compact('p_id');
    	}

    	$RS = DB::select($query,$param_arr);

    	if(count($RS) < 1) {
    		return response()->json(["msg" => "There is no data"]);
    	}
    	$RS = $RS[0];

    	return response()->json([
    							"msg" => "",
    							"rs" => $RS
    										]);
    }
}
