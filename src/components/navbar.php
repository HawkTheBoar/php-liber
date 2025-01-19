<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/utils/helpers.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/types/auth/user.php";
$routes = loadJson($_SERVER['DOCUMENT_ROOT'] . "/routes.json");
Navbar::setRoutes($routes);
class Navbar{
    static mixed $routes;
    public static function setRoutes($routes){
        self::$routes = $routes;
    }
    public static function render_admin(){
        start_session_if_not_started();
        $user = User::GetUserFromSession();
        ?>
        <nav class="h-[10vh] w-full bg-gray-800 text-white flex justify-between items-center p-4 px-12">
            <div><a href="<?php echo self::$routes['admin']['index'] ?>">Admin Panel</a></div>
            <div class="flex gap-x-8">
                <div><a href="">Hello, <?php echo $user->getUsername() ?></a></div>        
                <div><a href="<?php echo self::$routes['auth']['logout'] ?>">Log out</a></div>        
            </div>
        </nav>
        <?php
    }
    public static function render_public(){
        start_session_if_not_started();
        $user = User::GetUserFromSession();
        ?>
        <nav class="h-[10vh] w-full bg-gray-800 text-white flex justify-between items-center p-4 px-12">
            <div class="flex gap-x-8">
                <div class="mr-10">E-shop</div>
                <div><a href="/">Home</a></div>

            </div>
            <div>
                <div class="flex gap-x-8">
                    <?php if($user === null){ ?>
                    <div><a href="<?php echo self::$routes['auth']['login'] ?>">Login</a></div>
                    <div><a href="<?php echo self::$routes['auth']['register'] ?>">Register</a></div>
                    <?php } else { ?>
                    <div><a href="">Hello, <?php echo $user->getUsername() ?></a></div>        
                    <div><a href="<?php echo self::$routes['auth']['logout'] ?>">Log out</a></div>        
                </div>
                <?php } ?>
            </div>
        </nav>
        <?php
    }
}
?>

