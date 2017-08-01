<section class="dashboard-panel-izq">
  
</section>
<section class="dashboard-panel-der">
  <div class="dashboard-box">
    <div class="dashboard-box-title">
      <span>Solicitudes de Bodega</span>
      <span class="icono icon-cancel-circle"></span>
      <span class="icono max-min icon-circle-up"></span>
    </div>
    <div class="dashboard-box-content">
      <div class="chart-content">
        <canvas id="sols_bodega"></canvas>
      </div>
    </div>
  </div>
</section>

<script src=<?= base_url("assets/js/Chart.js")?>></script>
<script type="text/javascript">
  $(document).ready(function(){
    var lbls = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $.ajax({
      type: 'post',
      url: baseurl + "index.php/Dashboard/obtenerSolicitudesCompraBodegaUsuario",
      data: {},
      success: function(result) {
        var res = JSON.parse(result);

        var ctx = $("#sols_bodega");
        var data = {
          labels: lbls,
          datasets: [
              {
                  label: "Solicitudes de Bodega",
                  fill: false,
                  lineTension: 0.1,
                  backgroundColor: "rgba(255,179,71,0.4)",
                  borderColor: "rgba(255,179,71,1)",
                  borderCapStyle: 'butt',
                  borderDash: [],
                  borderDashOffset: 0.0,
                  borderJoinStyle: 'miter',
                  pointBorderColor: "rgba(255,179,71,1)",
                  pointBackgroundColor: "#fff",
                  pointBorderWidth: 1,
                  pointHoverRadius: 5,
                  pointHoverBackgroundColor: "rgba(255,179,71,1)",
                  pointHoverBorderColor: "rgba(220,220,220,1)",
                  pointHoverBorderWidth: 2,
                  pointRadius: 1,
                  pointHitRadius: 10,
                  data: [res[1]['enero'],res[1]['febrero'],res[1]['marzo'],res[1]['abril'],res[1]['mayo'],res[1]['junio'],res[1]['julio'],res[1]['agosto'],res[1]['septiembre'],res[1]['octubre'],res[1]['noviembre'],res[1]['diciembre']],
                  spanGaps: false,
              }
          ]
        };

        var line = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                scales: {
                    yAxes: [{
                        stacked: false
                    }]
                }
            }
        });
      },
    });

  });
</script>
