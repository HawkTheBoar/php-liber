<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/types/auth/user.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/utils/helpers.php";
$routes = loadJson($_SERVER['DOCUMENT_ROOT'] . "/routes.json");
// UserFactory::CreateAdmin('administrator', 'mistr302@email.cz', 'admin');
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
        if($user->getRole() === 'admin'){
            header("Location: " . $routes["admin"]["index"]);
        }
        else{
            header("Location: " . $routes["public"]["index"]);
        }
        exit();
    }
else{
    auth_failed('Invalid Credentials.');
}
}
else{
    include $_SERVER['DOCUMENT_ROOT'] . "/components/navbar.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/components/head.php";
    Navbar::render_public();
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