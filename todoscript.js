    /**
     * 確認ダイアログの返り値によりフォーム送信
    */
function submitChk () {
    /* 確認ダイアログ表示 */
    var flag = confirm ( "登録してもよろしいですか？\n取り消す場合は[キャンセル]ボタンを押して下さい");
    /* send_flg が TRUEなら送信、FALSEなら送信しない */
    return flag;
}

function errChk(){ //タスク登録時のエラーチェック
    if(document.getElementById('taskname').value === '' || document.getElementById('taskvalue').value === ''){
        alert("タスク名、またはまたは内容に不備があります。");
        return false;
    }
}

function comptask(){
    var div = document.createElement('div');

    fetch('https://blooming-ocean-46381.herokuapp.com/completetask.php')
    .then((response) => response.json())
    .then((json) => {
        for(let count=0;count <20; count++){

            console.log(json)
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

document.getElementById("resettaskmodal").onclick = function(){
    document.edittaskform.reset();
}