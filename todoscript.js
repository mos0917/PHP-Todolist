function onSignIn(googleUser) {/* google のログイン情報を取得*/
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
  }

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
        for(let count=0;count <20; count++){
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
