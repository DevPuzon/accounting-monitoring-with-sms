<?php

namespace App\Http\Controllers;

use App\Message as Message;
use App\ChatRoom as ChatRoom;
use App\User as User;
use App\Chat as Chat;
use App\Http\Resources\MessageResource;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($school_id)
    {
      return ($school_id > 0)? MessageResource::collection(Message::bySchool($school_id)->get()):response()->json([
        'Invalid School id: '. $school_id,
        404
      ]);
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
      $tb = new Message;
      $tb->phone_number = $request->phone_number;
      $tb->email = $request->email;
      $tb->message = $request->message;
      $tb->school_id = $request->school_id;

      return($tb->save())?response()->json([
        'status' => 'success'
        ]):response()->json([
          'status' => 'error'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new MessageResource(Message::find($id));
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
      $tb = Message::find($id);
      $tb->phone_number = $request->phone_number;
      $tb->email = $request->email;
      $tb->message = $request->message;
      $tb->school_id = $request->school_id;
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
      return (Message::destroy($id))?response()->json([
        'status' => 'success'
      ]):response()->json([
        'status' => 'error'
      ]);
    }


    public function getRoomChatbyID(Request $request)
    {
      $roomId = $request->room_id;
      $tb = Chat::find($id); 

      return ($tb)?response()->json([
        'status' => 'success' 
      ]):response()->json([
        'status' => 'error'
      ]);
    }

    public function sendChat(Request $request)
    { 
      $roomID = $request->room_id;



      $sender = $request->sender;
      $receiver = $request->receiver;
      $user_chat = $request->chat;

      // $findRoomID = ChatRoom::where('id', $roomID)->first();
      $findRoomID = $this->findChatRoomTwoParties($sender, $receiver);
      if(!$findRoomID){
        // no room ID;
        $chatRoom = new ChatRoom;
        $chatRoom->created_user_id = $sender;
        $chatRoom->participant_user_id = $receiver;
        $chatRoom->save();
        $findRoomID = $chatRoom->id;
      }

      $chat = new Chat;
      $chat->room_id = $findRoomID;
      $chat->sender_user_id = $sender;
      $chat->receiver_user_id = $receiver; 
      $chat->chat = $user_chat;


      return ($chat->save())?response()->json([
      'status' => 'success' 
      ]):response()->json([
      'status' => 'error'
      ]);
    }

    public function findChatRoomTwoParties($part1,$part2){
      $try1 = ChatRoom::where('created_user_id', $part1)
                      ->where('participant_user_id', $part2)->first();

      if($try1){ 
        return $try1->id;
      }

      $try2 = ChatRoom::where('created_user_id', $part2)
                      ->where('participant_user_id', $part1)->first();

      if($try2){ 
        return $try2->id;
      }

      return false;
    }


    public function getChatRoomID(Request $request){ 
      $roomID = $this->findChatRoomTwoParties($request->participant1,$request->participant2);
     
      return ($roomID > 0)?response()->json([
        'roomID' => $roomID
        ]):response()->json([
        'roomID' => null
        ]);
    }

    public function getConversation(Request $request){ 
      $roomID = $this->findChatRoomTwoParties($request->participant1,$request->participant2);
      $list = Chat::where('room_id',$roomID)->orderByDesc('created_at')->get();

      foreach($list as $data){
        $data->sender_user = User::find($data->sender_user_id);
      }

      return ($roomID > 0)?response()->json([
      'data' => $list
      ]):response()->json([
      'data' => []
      ]);
    }

    public function chatMain() { 
        return view('chat.main');
    }



    public function getUser(Request $request){  
      return response()->json([
        'data' => User::find($request->user_id)
      ]);
    }

    public function getListConvo(Request $request){ 
      $user_id = $request->user_id;
      $list = ChatRoom::where('created_user_id', $user_id)
                      ->orWhere('participant_user_id', $user_id)->get();

      foreach($list as $data){
        $data->user = User::find($data->created_user_id == $user_id ?  $data->participant_user_id :$data->created_user_id  );
      } 

      return response()->json([
        'data' => $list
      ]);
    }
}
