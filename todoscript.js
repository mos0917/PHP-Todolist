    /**
     * 確認ダイアログの返り値によりフォーム送信
    */
function submitChk () {
    /* 確認ダイアログ表示 */
    var flag = confirm ( "登録してもよろしいですか？\n取り消す場合は[キャンセル]ボタンを押して下さい");
    /* send_flg が TRUEなら送信、FALSEなら送信しない */
    return flag;
}

function logoutChk(){
    /*ログアウトボタン押下時ダイアログを表示*/
    var logoutflg = confirm("ログアウトしてもよろしいですか？\n取り消す場合は[キャンセル]ボタンを押してください");
    return logoutflg;
} 
    

function errChk(){ //タスク登録時のエラーチェック
    if(document.getElementById('taskname').value === '' || document.getElementById('taskvalue').value === ''){
        alert("タスク名、またはまたは内容に不備があります。");
    }
}