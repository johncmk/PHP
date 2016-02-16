<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class PagesController extends Controller
{
    /*
	* pages: name of the directory in the view
	* index: name of the blade page in 'pages' directory
    */
    public function index() {
    	return view('pages.index');
    }

    public function about() {
    	$about = array('name' => 'john',
    					'age' => 28);

    	return view('pages.about',compact('about'));
    }

    public function contact() {
        $contact = array(
                        'email' => 'john@example.com',
                        'Github' => 'john.github.com'
                        );

        return view('pages.contact',compact('contact'));
    }

    public function post() {

        // if(Auth::user() != null) {
        //     return view('pages.post',['username' => Auth::user()->name]);
        // } else {
        //     return view('pages.post',['username' => "Anonymous"]);
        // }

        // $range = 0;
        // $total_rows = 0;
        // $username = "Anonymous";
        // $rows_per_page = 0;
        // $total_pages = 0;
        // $current_page = 0;
        // $RS = array();

        // return view('pages.post',compact(
        //                                 'total_rows',
        //                                 'username',
        //                                 'rows_per_page',
        //                                 'total_pages',
        //                                 'current_page',
        //                                 'range',
        //                                 'RS'
        //                                                 ));
    }
}
