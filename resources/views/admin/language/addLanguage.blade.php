<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register Here</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <h2 class="text-center">Add Below</h2>
    <div class="container">
        <form action="{{ route('createLanguage') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Language Name</label>
                <input type="text" name="name" placeholder="Enter Language" class="form-control">
            </div>
            <div class="mb-3">
                <label>Language Code</label>
                <input type="text" name="code" placeholder="Enter Code" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Add New Here</button>
        </form>
    </div>
</body>
</html>
