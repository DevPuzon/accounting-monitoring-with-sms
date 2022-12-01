<?php

namespace App\Http\Controllers;

use App\Notification as Notification;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request; 

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
      $msg = Notification::with('teacher.department')->where('student_id',$id)->orderBy('id','desc')->paginate(10);
      $msgs = [];
      foreach($msg as $m){
        $msgs[] = [
            'id' => $m->id,
            'active' => 0,
            'updated_at' => date('Y-m-d H:i:s'),
          ];
      }
      $notifTb = new Notification;
      \Batch::update($notifTb,(array) $msgs,'id');
      return view('message.all',['messages'=>$msg]);
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
      $request->validate([
        'section_id' => 'required|numeric',
        'teacher_id' => 'required|numeric',
        'recipients' => 'required|array',
        'msg' => 'required|string',
      ]);
      //DB::transaction(function () {
      for($i=0; $i < count($request->recipients); $i++){
        $tb = new Notification;
        $tb->sent_status = 1;
        $tb->active = 1;
        $tb->message = $request->msg;
        $tb->student_id = $request->recipients[$i];
        $tb->user_id = $request->teacher_id;
        $tb->created_at = date('Y-m-d H:i:s');
        $tb->updated_at = date('Y-m-d H:i:s');
        $n[] = $tb->attributesToArray();
      }
      Notification::insert($n);
      //});
      return back()->with('status',__('Message Sent'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new NotificationResource(Notification::find($id));
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
      $tb = Notification::find($id);
      $tb->student_id = $request->student_id;
      $tb->message = $request->message;
      return ($tb->save())?response()->json([
        'status' => 'success'
      ]):response()->json([
        'status' => 'error'
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      return (Notification::destroy($id))?response()->json([
        'status' => 'success'
      ]):response()->json([
        'status' => 'error'
      ]);
    }

    public function pushNotification($token,$title,$message){
      
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
                          "notification":{
                          "title":"'.$title.'",
                          "body": "'.$message.'",
                          "sound":"default",
                          "click_action":"FCM_PLUGIN_ACTIVITY",
                          "icon":""
                          },
                          "data":{
                          "routes": ""
                          },
                          "to":"'.$token.'",
                          "priority":"high",
                          "restricted_package_name":""
                      }',
        CURLOPT_HTTPHEADER => array(
          'Authorization: key=AAAAMIZ4bAU:APA91bH6pfBQoT_MaY11S357GXuJt67zgH4eAbN3i7z6JpnsboUJ6Fd_nkeuHfp7M9uBALO0kb58Qowl1IJU6QvGNnJrA2WbgOcz3IVaXbCbtp2hkMWoTQkHvzWS2FiLQoMHNmBklJEF',
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      echo $response;

    }
    
}
