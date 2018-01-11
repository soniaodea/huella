@extends("layouts.userHome")

@section("title", "Cambiar contraseña")

@section("userContent")

    <h2>Cambiar contraseña</h2>

    @if(session()->has("changed"))
    <noscript>
        <div class="alert alert-success">
            <i class="fa fa-check"></i>&nbsp;{{ trans("passwords.reset") }}
        </div>
    </noscript>
    <script type="text/javascript" defer>
    document.addEventListener("DOMContentLoaded", function () {
        swal({
            icon: "success",
            title: "{{ trans("passwords.reset") }}"
        });
    });
    </script>
    @endif

    @include("forms.user.changePassword")

@endsection