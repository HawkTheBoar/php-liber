<?php
include_once "../types/auth/user.php";
include_once "../utils/helpers.php";

start_session_if_not_started();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
try{
    $email = getFromPostOrThrowError('email');
    $password = getFromPostOrThrowError('password');
    $user = new User($email);

} catch(Error $e){
    auth_failed('Email and password are required.');
}
try{

    $res = $user->Authenticate($password);
}
catch(InvalidArgumentException $e){
    auth_failed($e->getMessage());
}
catch(Exception $e){
    auth_failed('An error occured');
}
if($res){
    // echo "Authenticated!";
    $user->Login();
    header("Location: /admin/index.php");
    exit();
}
else{
    auth_failed('Invalid Credentials.');
}
}
else{
    ?>

    <form action="login.php" method="POST">

        <?php if(isset($_GET['error'])) echo $_GET['error']; ?>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Login</button>

    </form>



    <?

}