<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
</head>

<body>
  <?php
  //データベース接続(3-1)
  $dsn = 'mysql:dbname=tt_808_99sv_coco_com;host=localhost';
  $user = 'tt-808.99sv-coco';
  $password = 'R6aPnN4W';
  $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
  //テーブル作成(3-2)
  $sql="CREATE TABLE IF NOT EXISTS Mission41"
  ."("
  ."num INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
  ."name char(32),"
  ."comment TEXT,"
  ."date TEXT,"
  ."password char(32)"
  .");";
  $stmt = $pdo -> query($sql);

  //編集その1(2-4,2-5)
  if(!empty($_POST["ednum"]) && !empty($_POST["edpass"])){
    echo"編集";
    $ednum = $_POST["ednum"];
    $edpass = $_POST["edpass"];
    $sql = 'SELECT*FROM Mission41';
    $stmt = $pdo -> query($sql);
    foreach($stmt as $exe){
      if($_POST["ednum"] === $exe[0] && $_POST["edpass"] === $exe[4]){
        $eddnum = $exe[0];
        $edname = $exe[1];
        $edcom = $exe[2];
        $eddat = $exe[3];
        $edited_pass = $exe[4];

        echo"パスワードの一致を確認しました。<br>";
        echo"編集する投稿内容を呼び出します...<br>";
      }
      if($_POST["ednum"] === $exe[0] && $_POST["edpass"] !== $exe[4]){
        echo"パスワードが違います。<br>";
      }
    }
  }
  ?>

 <form method="post" action="">
 	<input type="text" name="name" placeholder="名前" value="<?php echo $edname;?>"></p>
 	<input type="text" name="comment"placeholder="コメント" value="<?php echo $edcom;?>"></p>
 	<input type="text" name="password" placeholder="パスワード" value="<?php echo $edited_pass;?>"></p>
 	<input type="hidden" name="pass" value="<?php echo $edited_pass;?>"></p>
 	<input type="submit" name="sbbtn" value="送信"></p>

 	<input type="hidden" name="Check" value="<?php echo $eddnum;?>" ></p>

 	<input type="text" name="delnum" placeholder="削除対象番号"></p>
 	<input type="text" name="delpass" placeholder="パスワード"></p>
 	<input type="submit" name="delbtn" value="削除"></p>

 	<input type="text" name="ednum" placeholder="編集対象番号"></p>
 	<input type="text" name="edpass" placeholder="パスワード"></p>
 	<input type="submit" name="edbtn" value="編集"></p>


<?php
 $name = $_POST["name"];
 $comment = $_POST["comment"];
 $date = date("Y/m/d H:i:s" );
 $password = $_POST["password"];
 $pass = $_POST["pass"];
 $Check = $_POST["Check"];

if(!empty($name) && !empty($comment) && !empty($password) && empty($Check)){
 echo"コメントが新規送信されました。<br>";
//3-5:insert
 $sql = $pdo -> prepare("INSERT INTO Mission41 (name,comment,date,password) VALUES(:name,:comment,:date,:password)");
 $sql -> bindParam(':name',$name,PDO::PARAM_STR);
 $sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
 $sql -> bindParam(':date',$date,PDO::PARAM_STR);
 $sql -> bindParam(':password',$password,PDO::PARAM_STR);

 $name=$_POST["name"];
 $comment=$_POST["comment"];
 $date=date("Y/m/d H:i:s" );
 $password=$_POST["password"];
 $sql -> execute();

}else{
 echo"名前・コメント・パスワードを入力してください。<br/><br/>";
}
 ?>

<?php
	//削除機能:3-8delete
 if(!empty($_POST["delnum"]) && !empty($_POST["delpass"])){
			 $sql='delete from Mission41 where num=:num and password=:delpass';
			 $stmt=$pdo->prepare($sql);
			 $stmt->bindParam(':num',$num,PDO::PARAM_INT);
       $stmt->bindParam(':delpass', $delpass, PDO::PARAM_INT);
			 $num=$_POST["delnum"];
       $delpass=$_POST["delpass"];
			 $stmt->execute();
			echo"対象の投稿内容を削除しました。<br>";
    }

  //編集機能
 if(!empty($name) && !empty($comment) && !empty($_POST["Check"]) && !empty($_POST["password"])){//pass delete
  //$sql = 'select from Mission41 where num=:num and pass=:edpass';
  //$stmt = $pdo -> prepare($sql);
  //$results = $stmt->fetchAll();
	//foreach($results as $exe){
		//if($_POST["Check"] === $exe[0]  && $_POST["pass"] === $exe[4]){
		//$new_name=$_POST["name"];
		//$new_comment=$_POST["comment"];
		//$new_time=date("Y/m/d H:i:s" );
		//$new_pass=$_POST["password"];
		 $sql='update Mission41 set name=:name,comment=:comment,date=:date,password=:password where num=:num';
		 $stmt=$pdo->prepare($sql);
		 $stmt->bindParam(':name',$name,PDO::PARAM_STR);
		 $stmt->bindParam(':comment',$comment,PDO::PARAM_STR);
		 $stmt->bindParam(':num',$num,PDO::PARAM_STR);
		 $stmt -> bindParam(':date',$date,PDO::PARAM_STR);
		 $stmt -> bindParam(':password',$password,PDO::PARAM_STR);

		 $num=$_POST["Check"];
		 $name=$_POST["name"];
		 $comment=$_POST["comment"];
		 $date=date("Y/m/d H:i:s" );
		 $stmt->execute();
		echo"対象の投稿内容を編集しました。<br>";
		//}else{
		//}
	 //}
 }
 //3-6:select表示
		 $sql='SELECT*FROM Mission41 ORDER BY num';
		 $stmt=$pdo -> query($sql);
		 $results=$stmt -> fetchAll();
		 foreach($results as $exe){
			echo $exe['num'].',';
			echo $exe['name'].',';
			echo $exe['comment'].',';
			echo $exe['date'].'<br>';
 		}
 ?>
</form>
</body>
</html>
