function errChk(){ //タスク登録時のエラーチェック
    var taskname = document.getElementById('taskname').value;
    var taskvalue = document.getElementById('taskvalue').value;

    if(taskname === "" || taskvalue === ""){
        if(!taskname.match(/\S/g) || !taskvalue.match(/\S/g)){
            alert("タスク名、またはまたは内容に不備があります。");
            return false;
        }
    }else{
        alert("タスクを登録しました。OKボタンを押下して確認して下さい。");
    }
}

function comptask(){//完了済みタスクを表示させるための処理
    var div = document.createElement('div');

    fetch('https://blooming-ocean-46381.herokuapp.com/completetask.php')
        .then((response) => response.json())
        .then((json) => {
            console.log(json)
            for(let count=0;count <20; count++){
                div = document.getElementById("comptaskid" + count)
                div.innerHTML = json.get[count].id

                div = document.getElementById("comptaskname" + count)
                div.innerHTML = json.get[count].name

                div = document.getElementById("comptaskvalue" + count)
                div.innerHTML = json.get[count].memo

                div = document.getElementById("compdeadline_date" + count)
                div.innerHTML = json.get[count].deadline_date
            }
        })
        .catch((error) => console.log(error));
}




