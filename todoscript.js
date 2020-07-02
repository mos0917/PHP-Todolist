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

            console.log(json)
            div = document.querySelector('.completetaskname')
            div.innerHTML = json.get.name

            div = document.querySelector('.completetaskvalue')
            div.innerHTML = json.get.memo

            div = document.querySelector('completetaskdeadline_date')
            div.innerHTML = json.get.deadline_date
    })
    .catch((error) => console.log(error));

}

document.getElementById("resettaskmodal").onclick = function(){
    document.edittaskform.reset();
}