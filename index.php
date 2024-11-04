<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live XML Update</title>
</head>
<body>
    <h2>Submit Information</h2>
    <form id="dataForm">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit">Submit</button>
    </form>

    <h2>Data from XML:</h2>
    <div id="xmlData">
        <?php include 'display.php'; ?>
    </div>

    <!-- Update Form (hidden by default) -->
    <div id="updateForm" style="display:none;">
        <h2>Update Information</h2>
        <form id="updateDataForm">
            <input type="hidden" id="updateId" name="id">
            <label for="updateName">Name:</label>
            <input type="text" id="updateName" name="name" required><br><br>

            <label for="updateEmail">Email:</label>
            <input type="email" id="updateEmail" name="email" required><br><br>

            <button type="submit">Update</button>
            <button type="button" onclick="document.getElementById('updateForm').style.display='none'">Cancel</button>
        </form>
    </div>

    <script>
        // Submit new data
        document.getElementById("dataForm").addEventListener("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('update.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(() => {
                refreshData();
                this.reset();
            });
        });

        // Edit an entry
        function editEntry(id, name, email) {
            document.getElementById('updateId').value = id;
            document.getElementById('updateName').value = name;
            document.getElementById('updateEmail').value = email;
            document.getElementById('updateForm').style.display = 'block';
        }

        // Submit updated data
        document.getElementById("updateDataForm").addEventListener("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('update.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(() => {
                refreshData();
                document.getElementById('updateForm').style.display = 'none';
            });
        });

        // Delete an entry with confirmation showing the specific name
        function deleteEntry(id, name) {
            if (confirm(`Are you sure you want to delete the details of ${name}?`)) {
                fetch('delete.php?id=' + id)
                .then(response => response.text())
                .then(() => {
                    refreshData();
                });
            }
        }

        // Auto-refresh the data every 5 seconds
        function refreshData() {
            fetch('display.php')
                .then(response => response.text())
                .then(data => document.getElementById('xmlData').innerHTML = data);
        }
        setInterval(refreshData, 5000);
    </script>
</body>
</html>
