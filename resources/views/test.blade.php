<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ trans('messages.welcome') }}</title>
</head>
<body>
<h1>{{ trans('messages.welcome') }}</h1>
  <div>
    <form action="{{ route('lang.switch') }}" method="POST">
      @csrf
      <select name="locale" onchange="this.form.submit()">
        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
        <option value="bg" {{ app()->getLocale() == 'bg' ? 'selected' : '' }}>Bulgarian</option>
      </select>
    </form>
  </div>

  @yield('content')
</body>
</html>
