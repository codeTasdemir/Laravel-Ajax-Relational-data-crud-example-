<!doctype html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png"  href="https://i0.wp.com/shiftdelete.net/wp-content/uploads/2021/05/symbol.png?resize=55%2C52&ssl=1">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<div class="container-fluid">
    <div class="row mt-5">
        <div class="col">
            <li class="list-group-item bg-warning active border-0 text-dark" aria-current="true"><h5>Yazar Tablosu</h5></li>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Yazar İd</th>
                    <th scope="col">Ad-Soyad</th>
                </tr>
                </thead>
                <tbody>
                @foreach($authors as $author)
                <tr class="text-muted">
                    <th scope="row">{{$author->id}}</th>
                    <th>{{$author->name}}</th>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col">
            <li class="list-group-item bg-warning active border-0 text-dark" aria-current="true"><h5>Kategori Tablosu </h5></li>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Kategori İD</th>
                    <th scope="col">Adı</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                <tr>
                    <th scope="row">{{$category->id}}</th>
                    <td>{{$category->category_name}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-4 m-auto">
            <form action="" method="post" class="">
                @csrf
                <li class="list-group-item bg-warning active border-0 text-danger mb-2 text-center" aria-current="true"><h5>Veri Ekle</h5></li>
                <div class="mb-3">
                    <input type="text" class="form-control" id="bookName" name="name" placeholder="Kitap Adı">
                </div>
                <div class="mb-3">
                    <select class="form-select" id="category_id" name="category_id" aria-label="Default select example">
                        <option selected>Kategori Seçiniz</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-select" id="author_id" name="author_id" aria-label="Default select example">
                        <option selected>Yazar Seçiniz</option>
                        @foreach($authors as $author)
                            <option value="{{$author->id}}">{{$author->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"  id="Ekle" class=" btn btn-warning w-100">Ekle</button>
            </form>
        </div>
        <div class="row">
        <div class="col-6 mt-5 mb-5 d-inline-block m-auto">
            <li class="list-group-item bg-success active border-0 text-dark" aria-current="true"><h5>Kitap Listesi</h5></li>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Kitap İd</th>
                    <th scope="col">Kitap Adı</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Yazar Adı</th>
                    <th scope="col">Sil</th>
                </tr>
                </thead>
                <tbody id="listeGovde">
                @foreach($books as $book)
                <tr>
                    <th scope="row">{{$book->id}}</th>
                    <td>{{$book->name}}</td>
                    <td>{{$book->Category->category_name}}</td>
                    <td>{{$book->Author->name}}</td>
                    <td><button data-token="{{ csrf_token() }}" data-id="{{$book->id}}" class="btn btn-danger sil">Sil</button></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>


<script type="text/javascript">

    //store AJAX
    $(document).ready(function (){
        $('#Ekle').click(function (e){
            e.preventDefault();
            var bookName = $('#bookName').val();
            var category = $('#category_id').val();
            var author = $('#author_id').val();

            $.ajax({
                type:'POST',
                url:'{{route('book.store')}}',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{
                    name:bookName,
                    category_id:category,
                    author_id:author,
                },
                success:function(data){
                    console.log(data);
                    $('#listeGovde').append('<tr><th scope="row">'+data.id+'</th> <td>'+data.name+'</td> <td>'+data.category_name+'</td> <td>'+data.author_name+'</td> <td><button data-token="{{ csrf_token() }}" data-id="'+data.id+'" class="btn btn-danger sil">Sil</button></td></tr>');
                }
            })

        })
    })
    //delete AJAX
    $(document).ready(function (){
        $('body').on('click','.sil', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var token = $(this).data('token');
            var btn = $(this);

            $.ajax({
                type:'DELETE',
                url: "relationIndex/delete/"+id,
                dataType:"JSON",
                data: {
                    "id": id,
                    "_method": 'DELETE',
                    "_token": token,
                },
                success: function (data) {
                    btn.parent().parent().remove();
                }
            })
        })
    })

</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
