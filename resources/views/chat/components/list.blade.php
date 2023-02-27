<div class="card-list" id="list"> 
</div>

<script>
    var list = $("#list");
    var user_id = document.getElementById("user_id").value;

    function render(){  
        var myHeaders = new Headers(); 
        var requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow'
        };

        fetch( `${ '{{url('message/get-list-convo')}}' }?user_id=${user_id}`, requestOptions)
        .then(response => response.text())
        .then(result => {
            var data = JSON.parse(result).data;
            for(let a of data){
                list.append(cardItem(a.user));
            }
            var user1 = data[0].user;
            updateConvoItem(user1.name,user1.pic_path,user1.id)
        })
        .catch(error => console.log('error', error));
    }
    function cardItem(user){
        return `<div class="card" onclick="updateConvoItem('${user.name}','${user.pic_path}','${user.id}')">
            <div class="card-body">
                <h4>${user.name}</h4>
            </div>
        </div>`;
    }

    render();

</script>

<style>
    .card{
        margin-bottom: 10px;
        cursor: pointer;
    }
    
    .card h4{
        margin: 0px;
    }

</style>