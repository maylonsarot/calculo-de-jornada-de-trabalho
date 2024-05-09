<?php

session_start();
include_once 'backend.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Calculadora de Jornada</title>
  </head>
  <body class="bg-dark text-white font-weight-light">
    <style>
        #comoUsar:hover{
            text-decoration: underline;
            cursor: help;
        }
    </style>

    <div class="container">

        <p class="text-center mt-4 mb-0" style="font-size: 20px;">Cáculo de jornada de trabalho</p>
        <p class="text-center mb-4 mt-0" style="font-size: 18px;"><a class="badge badge-dark font-italic" data-toggle="modal" data-target="#modalManual" id="comoUsar">Como utilizar?</a></p>

        
        <?php
            if (isset($_SESSION['alert'])){
                echo $_SESSION['alert'];
            }
            unset($_SESSION['alert']);
        ?>

        <form method="POST">

            <div class="row mb-3">
                <div class="col">
                    <label for="horaEntrada">Entrada</label>
                    <input type="time" class="form-control" id="horaEntrada" name="horaEntrada" value="<?php if(isset($_SESSION['parametros'])){echo converterParaHoras($_SESSION['parametros']->horaEntrada);}?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="horaSaidaIntervalo">Saída Intervalo</label>
                    <input type="time" class="form-control" id="horaSaidaIntervalo" name="horaSaidaIntervalo" value="<?php if(isset($_SESSION['parametros'])){echo converterParaHoras($_SESSION['parametros']->horaSaidaIntervalo);}?>" required>
                </div>
                <div class="col">
                    <label for="horaVoltaIntervalo">Volta Intervalo (Opcional)</label>
                    <input type="time" class="form-control" id="horaVoltaIntervalo" name="horaVoltaIntervalo" value="<?php if(isset($_SESSION['parametros']->horaVoltaIntervalo)){echo converterParaHoras($_SESSION['parametros']->horaVoltaIntervalo);}?>"  >
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="horaSaida">Saída (Opcional)</label>
                    <input type="time" class="form-control" id="horaSaida" name="horaSaida" value="<?php if(isset($_SESSION['parametros']->horaSaida)){echo converterParaHoras($_SESSION['parametros']->horaSaida);}?>"  >
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="tempoIntervalo">Tempo de intervalo desejado</label>
                        <select class="form-control"  id="tempoIntervalo" name="tempoIntervalo" >
                        <option value="01:05"<?php if(isset($_SESSION['parametros'])){ if (converterParaHoras($_SESSION['parametros']->tempoIntervalo) == '01:05'){ echo('selected');}}?>>01:05</option>
                        <option value="01:10"<?php if(isset($_SESSION['parametros'])){ if (converterParaHoras($_SESSION['parametros']->tempoIntervalo) == '01:10'){ echo('selected');}}?>>01:10</option>
                        <option value="01:15"<?php if(isset($_SESSION['parametros'])){ if (converterParaHoras($_SESSION['parametros']->tempoIntervalo) == '01:15'){ echo('selected');}}?>>01:15</option>
                        <option value="01:20"<?php if(isset($_SESSION['parametros'])){ if (converterParaHoras($_SESSION['parametros']->tempoIntervalo) == '01:20'){ echo('selected');}}?>>01:20</option>
                        <option value="01:25"<?php if(isset($_SESSION['parametros'])){ if (converterParaHoras($_SESSION['parametros']->tempoIntervalo) == '01:25'){ echo('selected');}}?>>01:25</option>
                        <option value="01:30"<?php if(isset($_SESSION['parametros'])){ if (converterParaHoras($_SESSION['parametros']->tempoIntervalo) == '01:30'){ echo('selected');}}?>>01:30</option>
                        <option value="01:35"<?php if(isset($_SESSION['parametros'])){ if (converterParaHoras($_SESSION['parametros']->tempoIntervalo) == '01:35'){ echo('selected');}}?>>01:35</option>
                        <option value="01:40"<?php if(isset($_SESSION['parametros'])){ if (converterParaHoras($_SESSION['parametros']->tempoIntervalo) == '01:40'){ echo('selected');}}?>>01:40</option>
                        <option value="01:45"<?php if(isset($_SESSION['parametros'])){ if (converterParaHoras($_SESSION['parametros']->tempoIntervalo) == '01:45'){ echo('selected');}}?>>01:45</option>
                        <option value="01:50"<?php if(isset($_SESSION['parametros'])){ if (converterParaHoras($_SESSION['parametros']->tempoIntervalo) == '01:50'){ echo('selected');}}?>>01:50</option>
                        <option value="01:55"<?php if(isset($_SESSION['parametros'])){ if (converterParaHoras($_SESSION['parametros']->tempoIntervalo) == '01:55'){ echo('selected');}}?>>01:55</option>
                    </select>
                </div>

            </div>

            <button type="submit" class="btn btn-outline-success" name="calcular">Calcular</button>
            <button type="button" class="btn btn-outline-danger" id="limpar">Limpar Campos Opcionais</button>
        </form>
    </div>

    <section>
        <footer class="text-center text-white mt-3">
            <div class="container p-4 pb-0">
                *O presente sistema não possui vínculo com nenhuma empresa, sendo de responsabilidade do usurio a forma de como utiliza o mesmo.
                Neste mesmo contexto, seus autores não poderão ser responsabilizados pelo uso incorreto ou indevido do mesmo.
                <br>
                <br>
                © 2023 - 2023 
                <br>
                Desenvolvido por
                <a class="text-white" href="https://www.instagram.com/maylon_sarot">Maylon Sarot</a>
            </div>
        </footer>
    </section>

    <div class="modal fade text-dark" tabindex="-1" role="dialog" id="modalManual">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modo de utilizar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <p>-> Os campos "Entrada" e "Saída intervalo", são obrigatórios;</p>
            <p>-> Se você não preencher o horrio de retorno do intervalo, o sistema calculará o 
                    horário de retorno de acordo com o campo "Tempo de intervalo desejado";</p>
            <p>-> Se você não preencher o campo "Saída", o sistema calculará o horário limite 
                para você bater o ponto, sem esturar o tempo;</p>
            <p>-> Se preencher todos os campos, será avaliado se houve divergências e se a 
                carga horária foi cumprida corretamente.</p>
            <p>-> Esta calculadora ainda não funciona para jornadas que se iniciam em um dia e terminam em outro.</p>
            
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-dark" tabindex="-1" role="dialog" id="modalResultado">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Jornada Calculada!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
            <?php
            if(isset($_SESSION['jornadaCalculada'])){
                echo $_SESSION['jornadaCalculada'];
            }
            ?>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
            </div>
        </div>
    </div>

        

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    <script>
        $('#limpar').on('click', function(){

            $('#horaVoltaIntervalo').val('');
            $('#horaSaida').val('');


        });
    </script>

    <?php
        if(isset($_SESSION['jornadaCalculada'])){
            echo "<script type='text/javascript'>
                    $(document).ready(function(){
                    $('#modalResultado').modal('show');
                    });
                    </script>";
        }
    ?>

</body>
</html>