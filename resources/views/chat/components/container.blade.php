
<div id="convo-container" style="display: none"   > 
  
    <div class="py-2 px-4 border-bottom d-none d-lg-block" style=" display: flex; border-bottom: 1px solid #DBDBDB; padding: 10px;">
        <div class="d-flex align-items-center py-1" style=" display: flex; place-items: center; column-gap: 10px; ">
            <div class="position-relative">
                <img id="user-profile" src="" class="rounded-circle mr-1" style=" border-radius: 100px; " width="40" height="40">
            </div>
            <div class="flex-grow-1 pl-3">
                <strong id="user-name"></strong> 
            </div> 
        </div>
    </div>

    <div class="position-relative">
        <div id="chat-messages" class="chat-messages p-4"  style=" height: 60vh; "> 
        </div>
    </div>

    
    <div class="" style=" display: flex; padding: 10px;  border-top: 1px solid #DBDBDB; ">
        <input id="input-txt" type="text" class="form-control" placeholder="Type your message">  
        <a onclick="onSend()" class="btn btn-primary"><i class="material-icons" style=" color: white; ">send</i>  </a>
    </div>
</div>


<script>   
    var user_id = document.getElementById("user_id").value;
    var sender =  user_id;
    var receiver = '';
    var renderConvoInterval = null;
    var chat_messages = $("#chat-messages");
    console.log("chat_messages");
    setInterval(() => {
        if(receiver){
            renderConvo();
            // if(renderConvoInterval && ){
            //     clearInterval(renderConvoInterval);
            // }
        }
    }, 1000);
    function updateConvoItem(name,pic_path,_receiver){ 
        receiver =  _receiver; 
        $("#convo-container").show();  
        $('#user-profile').attr('src',`${ '{{ url('') }}' }/${pic_path}`);
        $("#user-name").html(name); 
    } 

    function renderConvo(){ 
        var myHeaders = new Headers(); 
        var requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow'
        };
        
        fetch(`${ '{{ url('message/get-convo') }}' }?participant1=${sender}&participant2=${receiver}`, requestOptions)
        .then(response => response.text())
        .then(result => {
            const data = JSON.parse(result).data;
            let render_msg = "";
            for(let a of data){
                var sender_user = a.sender_user;
                if(user_id == a.sender_user_id){
                    render_msg += receiverTemplate(sender_user.name,sender_user.pic_path,a.chat,a.created_at);
                }else{
                    render_msg += senderTemplate(sender_user.name,sender_user.pic_path,a.chat,a.created_at);
                }
            }
            chat_messages.html(render_msg);
        })
        .catch(error => console.log('error', error));
    }

    function receiverTemplate(name,pic_path,message,timestamp){
        timestamp = new Date(timestamp).toLocaleDateString();
        timestamp = timestamp + " "+new Date(timestamp).toLocaleTimeString();
        return `<div class="chat-message-right pb-4">
                <div>
                    <img src="${ '{{ url('') }}' }/${pic_path}" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
                    
                </div>
                <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                    <div class="font-weight-bold mb-1">You</div>
                    ${message}
                </div>
            </div>`;
            // <div class="text-muted small text-nowrap mt-2">${timestamp}</div>
    }

    function senderTemplate(name,pic_path,message,timestamp){
        timestamp = new Date(timestamp).toLocaleDateString();
        timestamp = timestamp + " "+new Date(timestamp).toLocaleTimeString();
        return `<div class="chat-message-left pb-4">
                <div>
                    <img  src="${ '{{ url('') }}' }/${pic_path}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                  
                </div>
                <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                    <div class="font-weight-bold mb-1">${name}</div>
                    ${message}
                </div>
            </div>`;
            // <div class="text-muted small text-nowrap mt-2">${timestamp}</div>
    } 

    function onSend(){
        var txt = $("#input-txt").val();
        if(txt == ""){return;}
        var myHeaders = new Headers(); 
            var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch(`${ '{{ url('message/send-chat') }}' }?sender=${sender}&receiver=${receiver}&chat=${txt}`, requestOptions)
        .then(response => response.text())
        .then(result => { renderConvo();})
        .catch(error => console.log('error', error));

        $("#input-txt").val("");
    }
</script>

<style>
    input{
        border: 1px solid #DBDBDB;
        padding: 5px;
        border-radius: 3px;
    }

    body{margin-top:20px;}
    .pb-4{
        margin: 8px
    }
.flex-shrink-1{
    padding: 5px;
}
.chat-online {
    color: #34ce57
}

.chat-offline {
    color: #e4606d
}

.chat-messages {
    display: flex;
    flex-direction: column;
    max-height: 800px;
    overflow-y: scroll
}

.chat-message-left,
.chat-message-right {
    display: flex;
    flex-shrink: 0
}

.chat-message-left {
    margin-right: auto
}

.chat-message-right {
    flex-direction: row-reverse;
    margin-left: auto
}
.py-3 {
    padding-top: 1rem!important;
    padding-bottom: 1rem!important;
}
.px-4 {
    padding-right: 1.5rem!important;
    padding-left: 1.5rem!important;
}
.flex-grow-0 {
    flex-grow: 0!important;
}
.border-top {
    border-top: 1px solid #dee2e6!important;
} 
</style>