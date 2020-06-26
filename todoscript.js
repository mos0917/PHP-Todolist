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
    fetch('https://blooming-ocean-46381.herokuapp.com/completetask.php',{
        method: 'GET',
    })
    .then(response => {
        if(response.ok){
            return response.text();
        }else{
            return Promise.reject(new error('エラーです。'));
        }
    })
    .then(text =>{
        console.log(text);
    })
    .catch(e =>{
        console.log(e.message);//エラー
    })
}