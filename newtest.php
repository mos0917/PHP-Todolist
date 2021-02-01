
<div>
メールアドレス<input id="mailAddress" type="mailAddress" required/>
      </div>
      <div>
パスワード<input id="password" type="password" required/>
      </div>
        <button id="login">ログイン</button>
        <button id="register">新規登録</button>

<script>
    // Initialize Firebase
    var firebaseConfig = {
        apiKey: "AIzaSyCfr-SRsboT6mNPc8RBVZpTnDp64EbQzSA",
        authDomain: "todo-list-e74b4.firebaseapp.com",
        projectId: "todo-list-e74b4",
        storageBucket: "todo-list-e74b4.appspot.com",
        messagingSenderId: "102176473496",
        appId: "1:102176473496:web:50a47c0b1e5397b93f6bed",
        measurementId: "G-YZ31FBSYVB"
    };


    //新規登録処理
    register.addEventListener('click', function(e) {
        var mailAddress = document.getElementById('mailAddress').value;
        var password = document.getElementById('password').value;

        firebase.auth().createUserWithEmailAndPassword(mailAddress, password).catch(function(error) {
                alert('登録できません（' + error.message + '）');
        });
    });
</script>