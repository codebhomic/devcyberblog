    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['toggle_maintenance'] === "true" ? 'true' : 'false';

    // Update the config file
    $config_content = "<?php\nreturn [\n    'maintenance_mode' => $status,\n];\n?>";
    file_exists("includes/maintenance.php") ? file_put_contents('includes/maintenance.php', $config_content) : file_put_contents('../includes/maintenance.php', $config_content);
    
    
   echo json_encode(["success" => true, "status" => $status]);
    exit();

}
$config = file_exists("includes/maintenance.php") ? include('includes/maintenance.php') : include('../includes/maintenance.php');
$is_checked = $config['maintenance_mode'] ? "checked" : ""
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
session_start();

require_once '../includes/helper.php';
require_once '../includes/db_connect.php';
// Check if user is logged in and is admin
if (!is_login(true)){
    // header('location: ../login.php?next='.$_SERVER['REQUEST_URI']);
    redirect("login.php?next=".$_SERVER['REQUEST_URI']);
    exit();
}
// Set page title
$page_title = "Settings";

// Start output buffering
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
        <div class="row my-4">

<style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        .switch input { display: none; }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider { background-color: #2196F3; }
        input:checked + .slider:before { transform: translateX(26px); }
    </style>
    <div class="container">
            <h2>Toggle Maintenance Mode</h2>
                <span>OFF</span>
                <label class="switch">
                    <input id="maintenance_toggle" type="checkbox" name="toggle_maintenance" <?= $is_checked ?>>
                    <span class="slider"></span>
                </label>
                <span>ON</span>
            <p>Status: <span id="status_text"><?= $config['maintenance_mode'] ? 'ON' : 'OFF' ?></span></p>

        </div>
</div>

</div>
 <script>
       document.addEventListener("DOMContentLoaded", function () {
            const toggleSwitch = document.getElementById("maintenance_toggle");
            const statusText = document.getElementById("status_text");

            toggleSwitch.addEventListener("change", function () {
                console.log(toggleSwitch.checked);
                let status = toggleSwitch.checked ? "true" : "false";

                fetch(window.location.href, { 
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "toggle_maintenance=" + status
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        statusText.textContent = data.status === "true" ? "ON" : "OFF";
                    }
                })
                .catch(error => console.error("Error:", error));
            });
        });
    </script>
<?php
// Get the buffered content
$content = ob_get_clean();

// Include the layout
include 'admin_layout.php';
?>
