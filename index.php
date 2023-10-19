<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .confirmation {
            display: none;
        }

        .custom-dialog {
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            position: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .custom-dialog-content {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
        }

        .custom-dialog-content p {
            font-size: 16px;
            margin: 0;
            padding: 10px 0;
        }

        .custom-dialog-content button {
            background-color: blue;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .custom-dialog-content button:hover {
            background-color: darkblue;
        }
    </style>
</head>
<?php
session_start();
require_once("db.php");
?>

<?php
if (!isset($_SESSION["id"]) && !isset($_SESSION["username"])) {
    header("Location: login.php");
} else {
    if (isset($_GET['error'])) {
        echo "
            <div class='alert alert-danger text-center w-80 mx-auto fw-bold' role='alert'>
                Selected quest has been removed.
            </div>
        ";
    }
    echo "<div>";
    echo "Welcome " . htmlspecialchars($_SESSION['username']) . "<br />";
    echo "<a href= 'add.php'>Add Quest</a><br />";
    echo "<a href= 'logout.php'>Logout</a><br />";
    echo "</div>";
    echo "<br />";

    echo "<div class='task grid grid-cols-6 gap-3 text-center my-5'>";
    echo "<div><b>Title</b></div>";
    echo "<div><b>Detail</b></div>";
    echo "<div><b>Done</b></div>";
    echo "
        <div id='status'>
                <b>
                <select name='status' id='status-select'>
                <option value='All'>All</option>
                <option value='Not yet started'>Not yet started</option>
                <option value='Ongoing'>Ongoing</option>
                <option value='Done'>Done</option>
                </select>
                </b>
        </div>
    ";
    echo "<div><b>Remove</b></div>";
    echo "<div><b>Edit</b></div>";
    echo "</div>";

    echo "<div id='not-yet-started'>";
    $sql = "SELECT * FROM list WHERE id_user = ? AND `status` = 'Not yet started'";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_SESSION['id']]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='task grid grid-cols-6 gap-3 text-center my-5'>";
        echo "<div>" . $row['task_name'] . "</div>";
        echo "<div>" . $row['task_desc'] . "</div>";
        echo "<form id='checkboxForm" . $row['id'] . "' method='POST' action='checkbox.php'>";
        echo "<input type='checkbox' id='checkboxID" . $row['id'] . "' onclick='checkbox(" . $row['id'] . ")'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "</form>";
        echo "
            <div id='row-status'>
                <select name='status' id='row-status-select-{$row['id']}' onchange='redirectToStatusPage(this)'>
                    <option value='Not yet started' " . ($row['status'] == 'Not yet started' ? 'selected' : '') . ">Not yet started</option>
                    <option value='Ongoing' " . ($row['status'] == 'Ongoing' ? 'selected' : '') . ">Ongoing</option>
                    <option value='Done' " . ($row['status'] == 'Done' ? 'selected' : '') . ">Done</option>
                </select>
            </div>
        ";
        echo "<form id='delete" . $row['id'] . "' action='delete.php' method='POST'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "<button type='button' onclick='openCustomDialog(" . $row['id'] . ")'><b>Remove Quest</b></button>";
        echo "</form>";
        echo "<form id='delete" . $row['id'] . "' action='edit.php' method='POST'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "<button type='submit'><b>Edit Quest</b></button>";
        echo "</form>";
        echo "</div>";
    }
    echo "</div>";

    echo "<div id='ongoing'>";
    $sql = "SELECT * FROM list WHERE id_user = ? AND `status` = 'Ongoing'";

    $stmt = $db->prepare($sql);
    $stmt->execute([$_SESSION['id']]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='task grid grid-cols-6 gap-3 text-center'>";
        echo "<div>" . $row['task_name'] . "</div>";
        echo "<div>" . $row['task_desc'] . "</div>";
        echo "<form id='checkboxForm" . $row['id'] . "' method='POST' action='checkbox.php'>";
        echo "<input type='checkbox' id='checkboxID" . $row['id'] . "' onclick='checkbox(" . $row['id'] . ")'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "</form>";
        echo "
            <div id='row-status'>
                <select name='status' id='row-status-select-{$row['id']}' onchange='redirectToStatusPage(this)'>
                    <option value='Not yet started' " . ($row['status'] == 'Not yet started' ? 'selected' : '') . ">Not yet started</option>
                    <option value='Ongoing' " . ($row['status'] == 'Ongoing' ? 'selected' : '') . ">Ongoing</option>
                    <option value='Done' " . ($row['status'] == 'Done' ? 'selected' : '') . ">Done</option>
                </select>
            </div>
        ";
        echo "<form id='delete" . $row['id'] . "' action='delete.php' method='POST'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "<button type='button' onclick='openCustomDialog(" . $row['id'] . ")'><b>Remove Quest</b></button>";
        echo "</form>";
        echo "<form id='delete" . $row['id'] . "' action='edit.php' method='POST'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "<button type='submit'><b>Edit Quest</b></button>";
        echo "</form>";
        echo "</div>";
    }
    echo "</div>";

    echo "<div id='done'>";
    $sql = "SELECT * FROM list WHERE id_user = ? AND `status` = 'Done'";

    $stmt = $db->prepare($sql);
    $stmt->execute([$_SESSION['id']]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='task grid grid-cols-6 gap-3 text-center'>";
        echo "<div>" . $row['task_name'] . "</div>";
        echo "<div>" . $row['task_desc'] . "</div>";
        echo "<form id='checkboxForm" . $row['id'] . "' method='POST' action='checkboxrev.php'>";
        echo "<input type='checkbox' id='checkboxID" . $row['id'] . "' onclick='checkboxrev(" . $row['id'] . ")' checked>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "</form>";
        echo "
            <div id='row-status'>
                <select name='status' id='row-status-select-{$row['id']}' onchange='redirectToStatusPage(this)'>
                    <option value='Not yet started' " . ($row['status'] == 'Not yet started' ? 'selected' : '') . ">Not yet started</option>
                    <option value='Ongoing' " . ($row['status'] == 'Ongoing' ? 'selected' : '') . ">Ongoing</option>
                    <option value='Done' " . ($row['status'] == 'Done' ? 'selected' : '') . ">Done</option>
                </select>
            </div>
        ";
        echo "<form id='delete" . $row['id'] . "' action='delete.php' method='POST'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "<button type='button' onclick='openCustomDialog(" . $row['id'] . ")'><b>Remove Quest</b></button>";
        echo "</form>";
        echo "<form id='delete" . $row['id'] . "' action='edit.php' method='POST'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "<button type='submit'><b>Edit Quest</b></button>";
        echo "</form>";
        echo "</div>";
    }
    echo "</div>";
}
?>

<div class="confirmation" id="confirmation">
    <div id="customDialog" class="custom-dialog">
        <div class="custom-dialog-content">
            <p>Are you sure you want to delete this Quest?</p>
            <button id="confirmButton">Yes</button>
            <button onclick="closeCustomDialog()">No</button>
        </div>
    </div>
</div>

<script>
    var customDialog = document.getElementById("confirmation");

    function openCustomDialog(id) {
        customDialog.style.display = "block";

        document.getElementById("confirmButton").addEventListener("click", function () {
            document.getElementById('delete' + id).submit();
            closeCustomDialog();
        });
    }

    function closeCustomDialog() {
        customDialog.style.display = "none";
    }
</script>

<script>
    function checkbox(id) {
        document.getElementById('checkboxForm' + id).submit();
    }
    function checkboxrev(id) {
        document.getElementById('checkboxForm' + id).submit();
    }
</script>

<script>
    var statusSelect = document.getElementById("status-select");
    var notYetStartedStatus = document.getElementById("not-yet-started");
    var onGoingStatus = document.getElementById("ongoing");
    var doneStatus = document.getElementById("done");

    statusSelect.addEventListener('change', function () {
        var selectedValue = statusSelect.value;

        if (selectedValue === 'All') {
            notYetStartedStatus.style.display = 'block';
            onGoingStatus.style.display = 'block';
            doneStatus.style.display = 'block';
        }

        if (selectedValue === 'Not yet started') {
            notYetStartedStatus.style.display = 'block';
            onGoingStatus.style.display = 'none';
            doneStatus.style.display = 'none';
        }

        if (selectedValue === 'Ongoing') {
            notYetStartedStatus.style.display = 'none';
            onGoingStatus.style.display = 'block';
            doneStatus.style.display = 'none';
        }
        if (selectedValue === 'Done') {
            notYetStartedStatus.style.display = 'none';
            onGoingStatus.style.display = 'none';
            doneStatus.style.display = 'block';
        }
    });
</script>

<script>
    function redirectToStatusPage(selectElement) {
        var selectedValue = selectElement.value;
        var rowId = selectElement.id.split('-')[3]; // Mengambil ID baris
        window.location.href = 'status.php?id=' + rowId + '&status=' + selectedValue;
    }
</script>