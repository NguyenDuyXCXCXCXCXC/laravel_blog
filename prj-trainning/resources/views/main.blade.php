<!doctype html>
<html lang="en">

<head>
    <title>{{$title}}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/template/main/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/template/main/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/template/main/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/template/main/dist/css/mystyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>


<body class="container-fluid">
  <header class="container-fluid">
    <div class="container">
        <div class="row header-first mb-2">
            <div class="col-2 ">
                <a href="{{route('dashboard')}}">
                    <img class="rounded-circle" style="height: 70px;" src="/img_web/logo.jfif" alt="">
                </a>
            </div>
            <div class="col-2 pt-4" id="clock"></div>
            <div class="col-4 pt-3">
                <form action="">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control form-control-lg" value="{{$search}}" placeholder="Tìm kiếm tin tức">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-3 pt-4 text-center">
                @if(Auth::user() == null)
                    <a href="{{route('client.login')}}" class="text-decoration-none">
                        <p class="text-primary">Đăng nhập</p>
                    </a>
                @else
                    Xin chào <strong>{{Auth::user()->first_name }} {{Auth::user()->last_name }}</strong>
                    <p><a class="text-decoration-none text-info" href="{{route('client.profile')}}">Profile</a> <a class="text-decoration-none text-danger" href="{{route('client.logout')}}">logout</a></p>
                @endif

            </div>
        </div>
    </div>
    <div class="row header-second">
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
              <a class="navbar-brand" href="#"></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse d-flex justify-content-center " id="navbarNav">
                <ul class="navbar-nav text-center">
{{--                  <li class="nav-item" style="margin-right: 24px;">--}}
{{--                    <a class="nav-link active" aria-current="page" href="#">Home</a>--}}
{{--                  </li>--}}
                    @foreach($categories as $ca)
                        <li class="nav-item" style="margin-right: 24px;">
                            <a class="nav-link" href="#">{{$ca->name}}</a>
                        </li>
                    @endforeach
                </ul>
              </div>
            </div>
          </nav>
    </div>
  </header>
  <main style="min-height: 760px;">


@yield('content')




  </main>
  <footer class="bg-light text-center text-lg-start">
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2020 Copyright:
      <a class="text-dark" href="#">duc duy vti</a>
    </div>
    <!-- Copyright -->
  </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    <!-- jQuery -->
    <script src="/template/main/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/template/main/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/template/main/dist/js/adminlte.min.js"></script>



    <!-- jquery-validation -->
    <script src="/template/main/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="/template/main/plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    {{--<script src="/template/main/dist/js/demo.js"></script>--}}
    <!-- Page specific script -->
<script>

    setInterval(myTimer, 1000);

    function myTimer() {
        const date = new Date();
        document.getElementById("clock").innerHTML = date.toLocaleString();
    }
</script>

</body>

</html>
