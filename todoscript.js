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

/**function comptask(){
    const url = 'https://blooming-ocean-46381.herokuapp.com/footer.php';
    fetch(url).then(function(response) {
        return response.text();
    }).then(function(text) {
        var result = document.querySelector('#result');
        result.innerHTML = text;
    });
} */

fetch('https://blooming-ocean-46381.herokuapp.com/test.json')
.then(response => response.text())
.then(console.log(text));

function print_json($data) {
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($data);
}
