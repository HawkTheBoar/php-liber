<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/utils/helpers.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/types/auth/user.php";
class Navbar{
    public static function render_admin(){
        start_session_if_not_started();
        $user = User::GetUserFromSession();
        ?>
        <nav class="h-[10vh] w-full bg-gray-800 text-white flex justify-between items-center p-4 px-12">
            <div><a href="/admin">Admin Panel</a></div>
            <div class="flex gap-x-8">
                <div><a href="">Hello, <?php echo $user->getUsername() ?></a></div>        
                <div><a href="/admin/logout.php">Log out</a></div>        
            </div>
        </nav>
        <?php
    }
    public static function render_public(){
        start_session_if_not_started();
        $user = User::GetUserFromSession();
        ?>
        <nav class="h-[10vh] w-full bg-gray-800 text-white flex justify-between items-center p-4 px-12">
            <div><a href="/">Home</a></div>
            <div class="flex gap-x-8">
                <div><a href="">Hello, <?php echo $user->getUsername() ?></a></div>        
                <div><a href="/admin/logout.php">Log out</a></div>        
            </div>
        </nav>
        <?php
    }
}
?>

