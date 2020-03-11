@extends('layout')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

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
            <div class="form-check">
                <input id="remember" class="form-check-input" type="checkbox" name="remember" value="{{ old('remember') ? 'checked': '' }}">

               <label for="remember" class="form-check-label">Remember Me</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Login!</button>

    </form>
@endsection('content')

