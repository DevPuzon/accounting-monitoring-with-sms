<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Services\User\UserService;
use App\Fee;
use Illuminate\Support\Facades\DB;

class MobileController extends Controller
{
  
    protected $userService; 
    protected $fee; 

    public function __construct(UserService $userService,Fee $fee){
        $this->userService = $userService; 
        $this->fee = $fee; 
    }
    
    public function login()
    { 
        return view('mobile.login', []);
    }
    
    public function home()
    { 
        $user = $this->userService->getStudent(\Auth::user()->id); 
        return view('mobile.home', compact('user'));
    }

    public function dashboard()
    { 
        $user_id = \Auth::user()->id;
        $fees = $this->fee
                ->with(['payment'=>function($q) use ($user_id){
                    $q->where('user_id',$user_id);
                }])   
                ->where('user_id',$user_id)
                ->orWhere('user_id',0)
                ->get();
        return view('mobile.dashboard', ['fees'=>$fees,'user_id'=>$user_id]); 
    }

    public function notification()
    { 
        $user_id = \Auth::user()->id;
        $logs = DB::table('notification_logs')->where('user_id',$user_id)->get();
        return view('mobile.notification', ['logs'=>$logs,'user_id'=>$user_id]); 
    }


    

    public function index($school_id)
    { 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
    } 
}
