<?php
session_start();
require_once "includes/helper.php";
require_once "includes/db_connect.php";
$user = get_logged_in_user($conn);
if ($user){
    header('location: admin/dashboard.php');
    $_SESSION["message"] = "User is already Login";
}
$page_title = "Login Page";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // First check if user exists
    $query = "SELECT * FROM users WHERE username='$username'";
    $results = mysqli_query($conn, $query);

    if (mysqli_num_rows($results) == 1) {
        $user = mysqli_fetch_assoc($results);

        // Check if password matches (either hashed or plain)
        if (
            $user['password'] === NULL || $user['password'] === '' ||
            password_verify($password, $user['password']) ||
            $user['password'] === $password
        ) { // For legacy plain text passwords

            // If password was plain text or NULL, hash it for future use
            if ($user['password'] === NULL || $user['password'] === '' || $user['password'] === $password) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                mysqli_query($conn, "UPDATE users SET password = '$hashed_password' WHERE id = " . $user['id']);
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $user['user_type'];

            if ($user['user_type'] == 'admin') {
                header('location: admin/dashboard.php');
            } else {
                header('location: index.php');
            }
            exit();
        }
    }

    $error = "Wrong username/password combination";
}
ob_start();
?>


<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div
            class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <?php if (isset($error)): ?>
                    <div class="bg-red-700 text-white px-5 py-2 w-full"><?php echo $error; ?></div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="bg-green-700 text-white px-5 py-2 w-full"><?php echo $_SESSION['success'];
                    unset($_SESSION['success']); ?></div>
                <?php endif; ?>

                <?php if (isset($google_error)): ?>
                    <div class="bg-red-700 text-white px-5 py-2 w-full"><?php echo $google_error; ?></div>
                <?php endif; ?>

                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Log in to your account
                </h1>
                <form class="space-y-4 md:space-y-6" method="post">
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                            username</label>
                        <input type="text" name="username" id="username"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="enter your valid username" required="">
                    </div>
                    <div>
                        <label for="password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required="">
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <!-- <div class="flex items-center h-5">
                                <input id="remember" aria-describedby="remember" type="checkbox"
                                    class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-indigo-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-indigo-600 dark:ring-offset-gray-800"
                                    required="">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                            </div> -->
                        </div>
                        <a href="#"
                            class="text-sm font-medium text-indigo-600 hover:underline dark:text-indigo-500">Forgot
                            password?</a>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                        Log
                        in</button>
                    <!-- <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Don't have an account yet? <a href="#"
                            class="font-medium text-indigo-600 hover:underline dark:text-indigo-500">Sign up</a>
                    </p> -->
                </form>
            </div>
        </div>
    </div>
</section>
<?php
// Get the buffered content
$content = ob_get_clean();

// Include the layout
include 'includes/base_layout.php';
?>