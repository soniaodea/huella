@extends("layouts.userHome")

@section("title", "Estadísticas")

@section("userContent")
<div class="container">
    <h2>Gráficos</h2>
    <hr>

    <canvas id="chart"></canvas>
    <script>
        let buildings = {!! $buildings !!};

        @foreach($buildings as $i => $building)

            buildings[{{ $i }}].studies = Array();
            @foreach($building->studies()->orderBy("year", "asc")->get() as $study)
                @php
                if ($study->year < $year) {
                    $year = $study->year;
                }
                @endphp
                buildings[{{ $i }}].studies.push({!! $study !!});
            @endforeach

        @endforeach

        let years = Array();
        for (let year = {{ $year }}; year < new Date().getFullYear(); year++) {
            years.push(year);
        }

        let datasets = Array();
        buildings.forEach(function (building) {
            let color = Array();
            for(let i = 0; i < 3; i++) {
                color.push(Math.round(Math.random() * 256));
            }

            let dataset = {
                label: building.name,
                data: Array(),
                backgroundColor: "rgba(" + color[0] + ", " + color[1] + ", " + color[2] + ", .8)",
                borderColor: "black",
                borderWidth: 1,
            };

            years.forEach(function (year) {
                dataset.data.push(yearStudyValue(building.studies, year));
            });
            datasets.push(dataset);
        });

        function yearStudyValue(studies, year) {
            let studyValue = 0;
            for (let i = 0; i < studies.length; i++) {
                if (studies[i].year == year) {
                    return studies[i].carbon_footprint;
                }
            }

            return studyValue;
        }

        document.addEventListener("DOMContentLoaded", function () {
            let ctx = document.getElementById("chart").getContext("2d");
            let data = {
                labels: years,
                datasets: datasets
            };

            let buildingsChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        });
    </script>
</div>
@endsection
