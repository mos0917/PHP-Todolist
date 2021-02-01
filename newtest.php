
<div>
メールアドレス<input id="mailAddress" type="mailAddress" required/>
      </div>
      <div>
パスワード<input id="password" type="password" required/>
      </div>
        <button id="login">ログイン</button>
        <button id="register">新規登録</button>

<script>
    //新規登録処理
    register.addEventListener('click', function(e) {
        var mailAddress = document.getElementById('mailAddress').value;
        var password = document.getElementById('password').value;

        firebase.auth().createUserWithEmailAndPassword(mailAddress, password)
            .catch(function(error) {
                alert('登録できません（' + error.message + '）');
            });
    });
</script>