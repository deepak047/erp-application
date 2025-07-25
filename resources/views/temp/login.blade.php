<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Page</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<div class="row justify-content-center mt-5">
<div class="col-lg-4">
<div class="card">
<div class="card-header">
<h1 class="card-title">Login</h1>
</div>
<div class="card-body">
@if(Session::has('error'))
<div class="alert alert-danger" role="alert">
{{ Session::get('error') }}
</div>
@endif
<form action="{{ route('login') }}" method="POST">
@csrf
<div class="mb-3">
<label for="email" class="form-label">Email address</label>
<input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
</div>
<div class="mb-3">
<label for="password" class="form-label">Password</label>
<input type="password" name="password" class="form-control" id="password" required>
</div>
<div class="mb-3">
<div class="d-grid">
<button class="btn btn-primary">Login</button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>