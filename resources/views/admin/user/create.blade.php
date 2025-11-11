<main role="main" class="main-content">
<div class="card shadow mb-4">
    <div class="card-header">
        <strong class="card-title">{{$title}}</strong>
    </div>
    <div class="card-body">
    @isset($user)
             <form action="/admin/user/{{$user->id}}" method="POST">
                @method ('put')
             @else
             <form action="/admin/user" method="POST">
             @endisset

 
                @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                    <label for=""><b>Nama</b></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama" value="{{ isset($user) ? $user->name : '' }}" id="nameInput">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    </div>

                    <div class="form-group mb-3">
                    <label for=""><b>Email</b></label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror "  name="email" placeholder="Email" value = "{{ isset($user) ? $user->email : '' }}">

                    @error('email')
                    <div class="invalid-feedback">
                        Pengguna Tersebut Sudah Ada
                    </div>
                    @enderror
                               
                    </div>
                    <div class="form-group mb-3">
                    <label for=""><b>Password</b></label>
                    <input type="password" class="form-control  @error('password') is-invalid @enderror " name="password" placeholder="Password">

                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror


                    </div>
                    <div class="form-group mb-3">
                     <label for=""><b>Konfirmasi Password</b></label>
                    <input type="password" class="form-control  @error('re_password') is-invalid @enderror" name="re_password" placeholder="Password">

                    @error('re_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    </div>
                </div> <!-- /.col -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                    <label for=""><b>Role</b></label>
                    <select name="role" class="form-control @error('role') is-invalid @enderror" id="">
                        <option value="admin" @if(isset($user) && $user->role == 'admin') selected @endif>Admin</option>
                        <option value="kasir" @if(isset($user) && $user->role == 'kasir') selected @endif>Kasir</option>
                    </select>

                    @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    </div>
                    <div class="form-group mb-3">
                        <a href="/admin/user" class="btn btn-secondary mt-2"><i class="fe fe-arrow-left"></i></a>
                        <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('nameInput').addEventListener('input', function(event) {
        var inputValue = event.target.value;
        var sanitizedValue = inputValue.replace(/[^A-Za-z]/g, ''); // Remove non-alphabetic characters

        if (inputValue !== sanitizedValue) {
            event.target.value = sanitizedValue; // Update the input value
        }
    });
</script>