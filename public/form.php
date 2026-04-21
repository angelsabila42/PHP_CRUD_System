<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>

<body>
    <div class="container">
        <div class="centered-div">
            <h1>Student Management Portal</h1>
            <form action="create.php" method = "POST">
    
                <label for = "name">Name:</label> <input type = "text" name = "name" id = "name"><br><br>
                <label for = "email">Email:</label> <input type = "text" name = "email" id = "email"><br><br>
                <label for = "course">Course:</label> <input type = "text" name = "course" id = "course"><br><br>
                <label for = "phone">Phone Number:</label> <input type = "text" name = "phone" id = "phone"><br><br>
                <label for ="reg">Registration Number:</label><input type="text" name = "reg" id = "reg"><br><br>

                <input type="submit">
    </form>
        </div>
    </div>
</body>
</html>