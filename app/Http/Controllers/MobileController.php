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
        if(is_null(\Auth::user())){
            return redirect('/mobile/login');
        }else{ 
            $user = $this->userService->getStudent(\Auth::user()->id); 
            return view('mobile.home', compact('user'));
        }
    }

    function filter_fee($el){
        return $el->year_level;
    }
    public function dashboard(Request $request)
    { 
        if(is_null(\Auth::user())){
            return redirect('/mobile/login');
        }
        $filter = $request->query("filter");
        $user_id = \Auth::user()->id;
        // $fees = array();
        $fee_q = $this->fee
                ->with(['payment'=>function($q) use ($user_id){
                    $q->where('user_id',$user_id);
                }])   
                ->where('user_id',$user_id);
        if($filter == "other"){   
            $fee_q = $fee_q->whereNull('year_level');  
        }
        else{
            $fee_q = $fee_q->where('year_level',"!=","");
        }
        $fee_q = $fee_q->orWhere('user_id',0); 
        $fees = $fee_q->get(); 
        return view('mobile.dashboard', ['fees'=>$fees,'user_id'=>$user_id]); 
    }

    public function notification()
    { 
        if(is_null(\Auth::user())){
            return redirect('/mobile/login');
        }
        $user_id = \Auth::user()->id;
        $logs = DB::table('notification_logs')->where('user_id',$user_id)->get();
        return view('mobile.notification', ['logs'=>$logs,'user_id'=>$user_id]); 
    } 
    
    public function chat()
    {  
        return view('mobile.chat' ); 
    } 

    public function changePasswordGet()
    {
        return view('mobile.change_password');
    } 

    public function saveFcmToken()
    {
        return view('mobile.save_fcm_token');
    }

    public function deleteNotification($log_id){
        if(is_null(\Auth::user())){
            return redirect('/mobile/login');
        }
        $logs = DB::table('notification_logs')->where('id',$log_id)->delete();
       
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
