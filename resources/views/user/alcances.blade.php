@extends("layouts.userHome")

@section("title", (($action == "view") ? "Visualización" : "Gestión") . " de alcances")

@section("userContent")

    <div class="container">
        <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
            @if(count($studies) > 0)
                @foreach($studies as $study)
                <li class="nav-item">
                    <a class="nav-link{{ ($errors->first("inputYear") == $study->year || Session::get("showYear") == $study->year) ? " active" : "" }}" id="study-{{ $study->year }}-tab" data-toggle="tab" href="#study-{{ $study->year }}">
                        @if($study->carbon_footprint)
                        <i class="fa fa-paw" title="Huella calculada"></i>
                        @else
                        <i class="fa fa-exclamation-triangle text-warning" title="Huella no calculada"></i>
                        @endif
                        {{ $study->year }}
                    </a>
                </li>
                @endforeach
            @elseif(count($studies) == 0 && $action == "view")
            <li class="nav-item">
                <a class="nav-link active">
                    <i class="fa fa-exclamation-triangle text-warning" title="Huella no calculada"></i>
                    Sin alcances
                </a>
            </li>
            @endif

            @if($action == "create")
            <li class="nav-item">
                <a class="nav-link{{ (empty($errors->first("inputYear")) && !Session::get("showYear")) ? " active" : "" }}" id="contact-tab" data-toggle="tab" href="#contact">
                    <i class="fa fa-plus"></i>
                    Crear nuevo
                </a>
            </li>
            @endif
        </ul>
        <div class="tab-content" id="myTabContent">
            @if(count($studies) > 0)
                @foreach($studies as $study)
                <div class="tab-pane fade{{ ($errors->first("inputYear") == $study->year || Session::get("showYear") == $study->year) ? " show active" : "" }}" id="study-{{ $study->year }}">

                    @if(!$study->carbon_footprint)
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i>
                        <strong>¡Atención!</strong> no se ha realizado aún el cálculo de la huella. Finalice la introducción de los datos y pulse sobre el botón "calcular huella de carbono". Una vez calculada la huella NO podrá editar los campos.
                    </div>
                    @else
                    <div class="alert alert-info">
                        <strong><i class="fa fa-paw"></i></strong> Valor de la huella, {{ $study->carbon_footprint }}
                    </div>
                    @endif

                    @include("forms.user.alcances", ["study" => $study])
                </div>
                @endforeach
            @elseif(count($studies) == 0 && $action == "view")
            <p>
                No se ha encontrado ningún alcance finalizado, <a href="{{ route("alcancesCreate", ["id" => $id]) }}">acceder al panel de gestión</a>.
            </p>
            @endif

            @if($action == "create")
            <div class="tab-pane fade{{ (empty($errors->first("inputYear")) && !Session::get("showYear")) ? " show active" : "" }}" id="contact">
                @include("forms.user.alcances", ["study" => new App\Models\Study])
            </div>
            @endif
        </div>

    </div>
    <script src="{{ asset("assets/js/user/studies.js") }}" defer></script>

    @if($action == "view")
    <script type="text/javascript">
        $(function () {
            $("#myTab .nav-item .nav-link").last().addClass("show active");
            $("#myTabContent .tab-pane").last().addClass("show active");
        });
    </script>
    @endif

    @if(Session::get("showYear"))
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            swal({
                icon: "success",
                title: "Datos guardados",
                text: " ",
                timer: 1500,
                buttons: false
            });
        });
    </script>
    @endif

    @if($errors->has("year"))
    <script type="text/javascript">
        $(function () {
            if (!!$("#myTab").find("li.active")) {
                $("#myTab a").last().click();
            }
        });
    </script>
    @endif

@endsection
