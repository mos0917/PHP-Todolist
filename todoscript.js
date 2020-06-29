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
    .then((response) => response.text())
    .then((text) => {


    console(text)
    div = getElementById('comptaskname')
    div.innerHTML = text.get["name"]
    
    div = getElementById('comptaskvalue')
    div.innerHTML = text.get["memo"]

    div = getElementById('compdeadline_date')
    div.innerHTML = text.get["deadline_date"]
    })
    .catch((error) => console.log(error));


    //div.id = "hoge";
    //div.innerHTML = "hoge";
    
    //var body = document.getElementById('modalbody');
    //body.appendChild(div);

}
