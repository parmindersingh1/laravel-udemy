@extends('layout')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
            class="form-control {{ $errors->has('name') ? 'is-invalid' : ''  }}">

            @if ($errors->has('name'))
              <div class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
              </div>
            @endif

        </div>

        <div class="form-group">
            <label for="">E-mail</label>
            <input type="text" name="email" value="{{ old('email') }}" required
            class="form-control {{ $errors->has('email') ? 'is-invalid' : ''  }}">

            @if ($errors->has('email'))
              <div class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
              </div>
            @endif
        </div>

        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" required
            class="form-control {{ $errors->has('password') ? 'is-invalid' : ''  }}">

            @if ($errors->has('password'))
              <div class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
              </div>
            @endif

        </div>

        <div class="form-group">
            <label for="">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="form-control">
        </div>

        <button type="submit" class="btn btn-primary btn-block">Register!</button>



    </form>
@endsection('content')

