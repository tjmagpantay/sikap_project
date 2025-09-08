<!DOCTYPE html>
<html>
<head>
    <title>Resume Parser Prototype</title>
</head>
<body>
    <h2>Upload Resume (PDF)</h2>
    <form action="parse.php" method="post" enctype="multipart/form-data">
        <input type="file" name="resume" accept=".pdf" required>
        <button type="submit">Upload & Parse</button>
    </form>
</body>
</html>
