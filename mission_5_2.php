<!DOCTYPE html>

<?php	
$dsn = 'データベース名';
$user = 'ユーザー名'
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

if(!empty($_POST["e_num"])){
    $sql = 'SELECT * FROM tbtest_2 WHERE id=:id AND password=:password';

    $id=$_POST["e_num"];
    $editpass=$_POST["e_pass"];
    $stmt = $pdo->prepare($sql);                  
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->bindParam(':password', $editpass,PDO::PARAM_STR);
    $stmt->execute();                    
	$results = $stmt->fetchAll();
    $row = $results[0];
    }
?>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
    <form action="" method="post" >
        <input type="text"   name="name"     placeholder="お名前を入力してください"
        value=<?php 
                    if(!empty($_POST["e_num"])){
                    echo $row["name"];}
                ?>><br>
        
        <input type="text"   name="comment"      placeholder="コメントを入力してください"
        value=<?php
                    if(!empty($_POST["e_num"])){
                        echo $row["comment"];}
                ?>><br>
        <input type="text" name="password" placeholder="パスワード"><br>        
        <input type="text" name="ch_num"
        value=<?php
                    if(!empty($_POST["e_pass"])){
                    echo $row["id"];}?> >
        <input type="submit" name="submit"><br><br>



        <input type="text"   name="del_num"   placeholder="削除対象番号"><br>
        <input type="text" name="del_pass" placeholder="パスワード">
        <input type="submit" name="del_submit"   value="削除"><br><br>
        
        <input type="text" name="e_num"    placeholder="編集対象番号"><br>
        <input type="text" name="e_pass" placeholder="パスワード">
        <input type="submit" name="e_submit"   value="edit">

    </form>
    <?php
    
            $sql = "CREATE TABLE IF NOT EXISTS tbtest_2"
            ." ("
            . "id INT AUTO_INCREMENT PRIMARY KEY,"
            . "name char(32),"
            . "comment TEXT,"
            . "date TEXT,"
            . "password TEXT"
            .");";
            $stmt = $pdo->query($sql);//statement.query≒prepareユーザーの入力情報を含むか否かで区別。
            
if(!empty($_POST["submit"])){            //送信ボタンが押されて
            //新規投稿
            if(empty($_POST["ch_num"])){    
                if(empty($_POST["name"])){
                    echo "名前を入力してください<br>";
                }elseif(empty($_POST["comment"])){
                    echo "コメントを入力してください<br>";
                }elseif(empty($_POST["password"])){
                    echo "送信パスワードを入力してください<br>";
                }else{
                    $name= $_POST["name"];
                    $comment= $_POST["comment"];
                    $date= date("Y/m/d/H:i:s");
                    $password=$_POST["password"];
                    $sql = $pdo -> prepare("INSERT INTO tbtest_2 (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
                    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
                    //好きな名前、好きな言葉は自分で決めること
                    $sql -> execute();
                  
                }
            //編集機能
            }else{
                // $edit=$_POST["e_num"];
                // $edit_pass=$_POST["e_pass"];
                
                if(!empty($_POST["password"])){
                        $name= $_POST["name"];
                        $comment= $_POST["comment"];
                        $date= date("Y/m/d/H:i:s");
                        $edit_pass=$_POST["password"];
                        $id=$_POST["ch_num"];
                        $sql = 'UPDATE tbtest_2 SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                        $stmt->bindParam(':password', $edit_pass, PDO::PARAM_STR);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                       
                            echo "編集されました<br>";
                  
                        
                }
            }//elseの終わり
        }//ifの終わり//ok
    if(!empty($_POST["del_submit"])){ //もし削除番号が押されたら
            if(empty($_POST["del_num"]) && empty($_POST["del_pass"])){
                            echo "削除したい番号を入力してください<br>";
            }//ifの終わり
            elseif(!empty($_POST["del_num"]) && empty($_POST["del_pass"])){
                    echo "削除パスワードを入力してください<br>";
            }//elseifの終わり
            elseif(!empty($_POST["del_num"]) && !empty($_POST["del_pass"])){ 
                    $name= $_POST["name"];
                    $comment= $_POST["comment"];
                    $date= date("Y/m/d/H:i:s");
                    $password=$_POST["password"];
                    $delete=$_POST["del_num"];
                    $del_pass=$_POST["del_pass"];
                    $id=$_POST["del_num"];
                    $sql = 'delete from tbtest_2 where id=:id and password=:password';
	                $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->bindParam(':password', $del_pass, PDO::PARAM_STR);
	                $stmt->execute();
                    
                
                      
                        echo "削除が実行されました<br>";
              
            }//elseifの終わり
        }//elseifの終わり
        if(!empty($_POST["e_submit"])){
            
            if(empty($_POST["e_num"])){
                echo "編集したい番号を入力してください<br>";
            }elseif(empty($_POST["e_pass"])){
                echo "編集パスワードを入力してください<br>";
            }elseif(!empty($_POST["e_num"]) && !empty($_POST["e_pass"])){
                $edit=$_POST["e_num"];
                
                    
                
                    echo "編集が承諾されました<br>";
             
            }//elseifの終わり
        }//ifの終わり
        $sql = 'SELECT * FROM tbtest_2';
        $stmt = $pdo->query($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        
        $results = $stmt->fetchAll(); 
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'];
                echo $row["date"].'<br>';
                echo "<hr>";
            }
        

           
       
   
    ?>
</body>
</html>