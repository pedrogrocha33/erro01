<?php

if (@$produtos == 'ocultar') {
  echo "<script>window.location='../index.php'</script>";
  exit();
}

$pag = 'produtos';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seu Título</title>

  <!-- CSS do Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- CSS do Select2 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <!-- CSS do DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

  <!-- JS do jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- JS do Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <!-- JS do Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  <!-- JS do Select2 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <!-- JS do DataTables -->
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>


<body>
  <a class="btn btn-success mb-3" onclick="inserir()">
    <i class="fa fa-plus" aria-hidden="true"></i> Novo Produto
  </a>

  <div class="bs-example widget-shadow p-4" id="listar">
    <!-- Lista de produtos será carregada aqui -->
  </div>

  <!-- Modal Inserir-->
  <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title"><span id="titulo_inserir"></span></h4>
          <button id="btn-fechar" type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form">
          <div class="modal-body">

            <div class="row mb-3">
              <div class="col-md-7">
                <div class="form-group">
                  <label for="nome">Nome</label>
                  <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                </div>
              </div>

              <div class="col-md-5">
                <div class="form-group">
                  <label for="categoria">Categoria</label>
                  <select class="form-control sel2" id="categoria" name="categoria" style="width:100%;">
                    <?php
                    $query = $pdo->query("SELECT * FROM categorias ORDER BY id asc");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    if (count($res) > 0) {
                      foreach ($res as $row) {
                        echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
                      }
                    } else {
                      echo '<option value="0">Cadastre uma Categoria</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="descricao">Descrição <small>(Até 1000 Caracteres)</small></label>
              <input maxlength="1000" type="text" class="form-control" id="descricao" name="descricao"
                placeholder="Descrição do Produto">
            </div>

            <div class="row mb-3">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="valor_compra">Valor Compra</label>
                  <input type="text" class="form-control" id="valor_compra" name="valor_compra"
                    placeholder="Valor Compra">
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <label for="valor_venda">Valor Venda</label>
                  <input type="text" class="form-control" id="valor_venda" name="valor_venda" placeholder="Valor Venda">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label for="nivel_estoque">Alerta Estoque</label>
                  <input type="number" class="form-control" id="nivel_estoque" name="nivel_estoque"
                    placeholder="Nível Mínimo">
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <label for="tem_estoque">Tem Estoque?</label>
                  <select class="form-control" id="tem_estoque" name="tem_estoque" style="width:100%;">
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label for="guarnicoes">Quantidade Guarnições</label>
                  <input type="number" class="form-control" id="guarnicoes" name="guarnicoes" placeholder="Se Houver">
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="promocao">Promoção?</label>
                  <select class="form-control" id="promocao" name="promocao" style="width:100%;">
                    <option value="Não">Não</option>
                    <option value="Sim">Sim</option>
                  </select>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <label for="combo">Combo?</label>
                  <select class="form-control" id="combo" name="combo" style="width:100%;">
                    <option value="Não">Não</option>
                    <option value="Sim">Sim</option>
                  </select>
                </div>
              </div>



              <div class="row mb-3">
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="foto">Foto</label>
                    <input class="form-control" type="file" name="foto" onChange="carregarImg();" id="foto">
                  </div>
                </div>

                <div class="col-md-4">
                  <div id="divImg">
                    <img src="images/produtos/sem-foto.jpg" width="80px" id="target">
                  </div>
                </div>
              </div>

              <input type="hidden" name="id" id="id">

              <br>
              <small>
                <div id="mensagem" align="center"></div>
              </small>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Dados-->
  <div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title" id="exampleModalLabel"><span id="nome_dados"></span></h4>
          <button id="btn-fechar-perfil" type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row mb-3">
            <div class="col-md-7">
              <span><b>Categoria: </b></span>
              <span id="categoria_dados"></span>
            </div>

            <div class="col-md-5">
              <span><b>Valor Compra: </b></span>
              <span id="valor _compra_dados"></span>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-7">
              <span><b>Valor Venda: </b></span>
              <span id="valor_venda_dados"></span>
            </div>

            <div class="col-md-5">
              <span><b>Estoque: </b></span>
              <span id="estoque_dados"></span>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <span><b>Alerta Nível Mínimo Estoque: </b></span>
              <span id="nivel_estoque_dados"></span>
            </div>

            <div class="col-md-6">
              <span><b>Tem Estoque: </b></span>
              <span id="tem_estoque_dados"></span>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <span><b>Promoção: </b></span>
              <span id="promocao_dados"></span>
            </div>

            <div class="col-md-6">
              <span><b>Combo: </b></span>
              <span id="combo_dados"></span>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-12">
              <span><b>Descrição: </b></span>
              <span id="descricao_dados"></span>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <span><b>Guarnições: </b></span>
              <span id="guarnicoes_dados"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12" align="center">
              <img width="250px" id="target_mostrar">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Saida-->
  <div class="modal fade" id="modalSaida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title" id="exampleModalLabel"><span id="nome_saida"></span></h4>
          <button id="btn-fechar-saida" type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-saida">

            <div class="row mb-3">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="quantidade_saida">Quantidade Saída</label>
                  <input type="number" class="form-control" id="quantidade_saida" name="quantidade_saida"
                    placeholder="Quantidade Saída" required>
                </div>
              </div>

              <div class="col-md-5">
                <div class="form-group">
                  <label for="motivo_saida">Motivo Saída</label>
                  <input type="text" class="form-control" id="motivo_saida" name="motivo_saida"
                    placeholder="Motivo Saída" required>
                </div>
              </div>

              <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Salvar</button>
              </div>
            </div>

            <input type="hidden" id="id_saida" name="id">
            <input type="hidden" id="estoque_saida" name="estoque">

            <br>
            <small>
              <div id="mensagem-saida" align="center"></div>
            </small>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Entrada-->
  <div class="modal fade" id="modalEntrada" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title" id="exampleModalLabel"><span id="nome_entrada"></span></h4>
          <button id="btn-fechar-entrada" type="button" class="btn-close text-white" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="form-entrada">
            <div class="row mb-3">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="quantidade_entrada">Quantidade Entrada</label>
                  <input type="number" class="form-control" id="quantidade_entrada" name="quantidade_entrada"
                    placeholder="Quantidade Entrada" required>
                </div>
              </div>

              <div class="col-md-5">
                <div class="form-group">
                  <label for="motivo_entrada">Motivo Entrada</label>
                  <input type="text" class="form-control" id="motivo_entrada" name="motivo_entrada"
                    placeholder="Motivo Entrada" required>
                </div>
              </div>

              <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Salvar</button>
              </div>
            </div>

            <input type="hidden" id="id_entrada" name="id">
            <input type="hidden" id="estoque_entrada" name="estoque">

            <br>
            <small>
              <div id="mensagem-entrada" align="center"></div>
            </small>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Variações-->
  <div class="modal fade" id="modalVariacoes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title" id="exampleModalLabel"><span id="titulo_nome_var"></span></h4>
          <button id="btn-fechar-var" type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-var">

            <div class="row mb-3">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="variacoes">Variação</label>
                  <div id="listar_var_cat">
                    <!-- Lista de variações será carregada aqui -->
                  </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label for="valor_var">Valor</label>
                  <input type="text" class="form-control" id="valor_var" name="valor" placeholder="50,00" required>
                </div>
              </div>

              <div class="col-md-3" style="margin-top: 20px">
                <button type="submit" class="btn btn-primary">Salvar</button>
              </div>
            </div>

            <input type="hidden" id="id_var" name="id">

            <br>
            <small>
              <div id="mensagem-var" align="center"></div>
            </small>

            <hr>
            <div id="listar-var"></div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Grades-->
  <div class="modal fade" id="modalGrades" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title" id="exampleModalLabel"><span id="titulo_nome_grades"></span></h4>
          <button id="btn-fechar-grades" type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-grades">

            <div class="row mb-3">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="texto">Descrição na hora da compra <small>(Até 70 Caracteres)</small></label>
                  <input maxlength="70" type="text" class="form-control" id="texto" name="texto"
                    placeholder="Descrição do item" required>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="tipo_item"> Tipo Item</label>
                  <select class="form-control" id="tipo_item" name="tipo_item" style="width:100%;">
                    <option value="Único">Seletor Único</option>
                    <option value="Múltiplo">Seletor Múltiplos</option>
                    <option value="1 de Cada">1 item de Cada</option>
                    <option value="Variação">Variação Produto</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-9">
                <div class="form-group">
                  <label for="nome_comprovante">Descrição Comprovante <small>(Até 70 Caracteres)</small></label>
                  <input maxlength="70" type="text" class="form-control" id="nome_comprovante" name="nome_comprovante"
                    placeholder="Descrição do item no comprovante" required>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label for="adicional">É Adicional?</label>
                  <select class="form-control" id="adicional" name="adicional" style="width:100%;">
                    <option value="Não">Não</option>
                    <option value="Sim">Sim</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-5">
                <div class="form-group">
                  <label for="valor_item">Tipo Valor</label>
                  <select class="form-control" id="valor_item" name="valor_item" style="width:100%;">
                    <option value="Agregado">Valor Agregado</option>
                    <option value="Único">Valor Único Produto</option>
                    <option value="Produto">Mesmo Valor do Produto</option>
                    <option value="Sem Valor">Sem Valor</option>
                  </select>
                </div>
              </div>

              <div class="col-md-5">
                <div class="form-group">
                  <label for="limite">Limite de Seleção Itens</label>
                  <input type="number" class="form-control" id="limite" name="limite"
                    placeholder="Selecionar até x Itens">
                </div>
              </div>

              <div class="col-md-5">
                <div class="form-group">
                  <label for="exampleInputEmail1">Quantidade minima</label>
                  <input type="number" class="form-control" id="quantidade_minima" name="quantidade_minima"
                    placeholder="Selecionar até x Itens">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="quantidade_minima">Quantidade Mínima</label>
                    <input type="number" class="form-control" id="quantidade_minima" name="quantidade_minima"
                      placeholder="Quantidade mínima">
                  </div>
                </div>
              </div>

              <div class="col-md-2" style="margin-top: 20px">
                <button id="btn_grade" type="submit" class="btn btn-primary">Salvar</button>
              </div>
            </div>

            <input type="hidden" id="id_grades" name="id">
            <input type="hidden" id="id_grade_editar" name="id_grade_editar">

            <br>
            <small>
              <div id="mensagem-grades" align="center"></div>
            </small>

            <hr>
            <div id="listar-grades"></div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Itens-->
  <div class="modal fade" id="modalItens" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title" id="exampleModalLabel"><span id="titulo_nome_itens"></span></h4>
          <button id="btn-fechar-var" type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-itens">

            <div class="row mb-3">
              <div class="col-md-12" id="div_nome">
                <div class="form-group">
                  <label for="texto_item">Nome <small>(Até 70 Caracteres)</small></label>
                  <input maxlength="70" type="text" class="form-control" id="texto_item" name="texto"
                    placeholder="Descrição do item">
                </div>
              </div>

              <div class="col-md-12" id="div_adicional">
                <div class="form-group">
                  <label for="adicional_grade">Escolher Adicional</label>
                  <select class="form-control sel5" id="adicional_grade" name="adicional" style="width:100%;"
                    onchange="alterarValor()">
                    <option value="">Selecione um Adicional</option>
                    <?php
                    $query = $pdo->query("SELECT * FROM adicionais ORDER BY nome asc");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    if (count($res) > 0) {
                      foreach ($res as $row) {
                        echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
                      }
                    } else {
                      echo '<option value="">Cadastre os Adicionais</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="valor_do_item">Valor</label>
                  <input type="text" class="form-control" id="valor_do_item" name="valor" placeholder="Valor Se Houver">
                </div>
              </div>

              <div class="col-md-5">
                <div class="form-group">
                  <label for="limite_itens">Limite de Seleção Itens</label>
                  <input type="number" class="form-control" id="limite_itens" name="limite"
                    placeholder="Selecionar até x Itens">
                </div>
              </div>

              <div class="col-md-3" style="margin-top: 20px">
                <button id="btn_itens" type="submit" class="btn btn-primary">Salvar</button>
              </div>
            </div>

            <input type="hidden" id="id_item" name="id">
            <input type="hidden" id="id_item_produto" name="id_item_produto">
            <input type="hidden" id="e_adicional" name="e_adicional">
            <input type="hidden" id="id_item_editar" name="id_item_editar">

            <br>
            <small>
              <div id="mensagem-itens" align="center"></div>
            </small>

            <hr>
            <div id="listar-itens"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    function abrirModal(id) {
      $('.modal').modal('hide'); // Oculta todos os modais abertos
      $('#' + id).modal('show'); // Mostra o modal específico
    }
  </script>

  <script type="text/javascript">var pag = "<?= $pag ?>"</script>

  function listar() {
  $.ajax({
  url: 'pages/produtos/listar.php', // Verifique se o caminho está correto
  method: 'POST',
  dataType: 'html',
  success: function (result) {
  $('#listar').html(result); // Atualiza a div com a lista de produtos
  $('#tabela').DataTable(); // Inicializa o DataTable após a atualização
  },
  error: function (xhr, status, error) {
  console.error('Erro ao listar produtos:', error);
  }
  });
  }
  <script type="text/javascript">
    function carregarImg() {
      var target = document.getElementById('target');
      var file = document.querySelector("#foto").files[0];
      var reader = new FileReader();

      reader.onloadend = function () {
        target.src = reader.result;
      };

      if (file) {
        reader.readAsDataURL(file);
      } else {
        target.src = "";
      }
    }
  </script>


  <script>
    document.getElementById('form-grades').addEventListener('submit', function (event) {
      event.preventDefault(); // Impede o envio padrão do formulário

      const formData = new FormData(this); // Captura todos os dados do formulário

      fetch('produtos/ajax-quantidade-minima.php', { // Altere para o seu script de backend
        method: 'POST',
        body: formData
      })
        .then(response => response.text()) // Espera a resposta do servidor
        .then(data => {
          console.log(data); // Exibe a resposta do servidor no console
          // Aqui você pode adicionar lógica para lidar com a resposta, como fechar o modal ou mostrar uma mensagem
          document.getElementById('mensagem-grades').innerHTML = data; // Exibe a mensagem na div
          $('#modalGrades').modal('hide'); // Fecha o modal após o envio
        })
        .catch(error => console.error('Erro:', error)); // Exibe erros no console
    });
  </script>


  <script type="text/javascript">
    $("#form-saida").submit(function (event) {
      event.preventDefault();
      var formData = new FormData(this);

      $.ajax({
        url: 'pages/produtos/saida.php',
        type: 'POST',
        data: formData,
        success: function (mensagem) {
          $('#mensagem-saida').text('');
          $('#mensagem-saida').removeClass();
          if (mensagem.trim() == "Salvo com Sucesso") {
            $('#btn-fechar-saida').click();
            listar();
          } else {
            $('#mensagem-saida').addClass('text-danger');
            $('#mensagem-saida').text(mensagem);
          }
        },
        cache: false,
        contentType: false,
        processData: false,
      });
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function () {
      $("#form-entrada").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
          url: 'pages/produtos/entrada.php',
          type: 'POST',
          data: formData,
          success: function (mensagem) {
            $('#mensagem-entrada').text('');
            $('#mensagem-entrada').removeClass();
            if (mensagem.trim() == "Salvo com Sucesso") {
              $('#btn-fechar-entrada').click(); // Fecha o modal
              listar(); // Chama a função listar()
            } else {
              $('#mensagem-entrada').addClass('text-danger');
              $('#mensagem-entrada').text(mensagem);
            }
          },
          cache: false,
          contentType: false,
          processData: false,
        });
      });
    });
  </script>

  <script type="text/javascript">
    $("#form-var").submit(function (event) {
      event.preventDefault();
      var id_var = $('#id_var').val();
      var formData = new FormData(this);

      $.ajax({
        url: 'pages/produtos/inserir-variacoes.php',
        type: 'POST',
        data: formData,
        success: function (mensagem) {
          $('#mensagem-var').text('');
          $('#mensagem-var').removeClass();
          if (mensagem.trim() == "Salvo com Sucesso") {
            listarVariacoes(id_var);
            limparCamposVar();
          } else {
            $('#mensagem-var').addClass('text-danger');
            $('#mensagem-var').text(mensagem);
          }
        },
        cache: false,
        contentType: false,
        processData: false,
      });
    });

    function limparCamposVar() {
      $('#nome_var').val('');
      $('#valor_var').val('');
      $('#sigla').val('');
      $('#descricao_var').val('');
    }

    function listarVariacoes(id) {
      $.ajax({
        url: 'pages/produtos/listar-variacoes.php',
        method: 'POST ',
        data: { id },
        dataType: "html",
        success: function (result) {
          $("#listar-var").html(result);
          $('#mensagem-excluir-var').text('');
        }
      });
    }

    function excluirVar(id) {
      var id_var = $('#id_var').val();
      $.ajax({
        url: 'pages/produtos/exclui-variacoes.php',
        method: 'POST',
        data: { id },
        dataType: "text",
        success: function (mensagem) {
          if (mensagem.trim() == "Excluído com Sucesso") {
            listarVariacoes(id_var);
          } else {
            $('#mensagem-excluir-var').addClass('text-danger');
            $('#mensagem-excluir-var').text(mensagem);
          }
        }
      });
    }

    function ativarVar(id, acao) {
      var id_var = $('#id_var').val();
      $.ajax({
        url: 'pages/produtos/mudar-status-var.php',
        method: 'POST',
        data: { id, acao },
        dataType: "text",
        success: function (mensagem) {
          if (mensagem.trim() == "Alterado com Sucesso") {
            listarVariacoes(id_var);
          } else {
            $('#mensagem-excluir-var').addClass('text-danger');
            $('#mensagem-excluir-var').text(mensagem);
          }
        }
      });
    }
  </script>

  <script type="text/javascript">
    $("#form-grades").submit(function (event) {
      event.preventDefault();
      var id_var = $('#id_grades').val();
      var formData = new FormData(this);

      $.ajax({
        url: 'pages/produtos/inserir-grades.php',
        type: 'POST',
        data: formData,
        success: function (mensagem) {
          $('#mensagem-grades').text('');
          $('#mensagem-grades').removeClass();
          if (mensagem.trim() == "Salvo com Sucesso") {
            listarGrades(id_var);
            limparCamposGrades();
          } else {
            $('#mensagem-grades').addClass('text-danger');
            $('#mensagem-grades').text(mensagem);
          }
        },
        cache: false,
        contentType: false,
        processData: false,
      });
    });

    function limparCamposGrades() {
      $('#texto').val('');
      $('#limite').val('');
      $('#nome_comprovante').val('');
    }

    function listarGrades(id) {
      $.ajax({
        url: 'pages/produtos/listar-grades.php',
        method: 'POST',
        data: { id },
        dataType: "html",
        success: function (result) {
          $("#listar-grades").html(result);
          $('#mensagem-excluir-grades').text('');
        }
      });
    }

    function excluirGrades(id) {
      var id_var = $('#id_grades').val();
      $.ajax({
        url: 'pages/produtos/excluir-grade.php',
        method: 'POST',
        data: { id },
        dataType: "text",
        success: function (mensagem) {
          if (mensagem.trim() == "Excluído com Sucesso") {
            listarGrades(id_var);
          } else {
            $('#mensagem-excluir-grades').addClass('text-danger');
            $('#mensagem-excluir-grades').text(mensagem);
          }
        }
      });
    }

    function ativarGrades(id, acao) {
      var id_var = $('#id_grades').val();
      $.ajax({
        url: 'pages/produtos/mudar-status-grade.php',
        method: 'POST',
        data: { id, acao },
        dataType: "text",
        success: function (mensagem) {
          if (mensagem.trim() == "Alterado com Sucesso") {
            listarGrades(id_var);
          } else {
            $('#mensagem-excluir-grades').addClass('text-danger');
            $('#mensagem-excluir-grades').text(mensagem);
          }
        }
      });
    }
  </script>

  <script type="text/javascript">
    $("#form-itens").submit(function (event) {
      event.preventDefault();
      var id_var = $('#id_item').val();
      var formData = new FormData(this);

      $.ajax({
        url: 'pages/produtos/inserir-itens.php',
        type: 'POST',
        data: formData,
        success: function (mensagem) {
          $('#mensagem-itens').text('');
          $('#mensagem-itens').removeClass();
          if (mensagem.trim() == "Salvo com Sucesso") {
            listarItens(id_var);
            limparCamposItens();
          } else {
            $('#mensagem-itens').addClass('text-danger');
            $('#mensagem-itens').text(mensagem);
          }
        },
        cache: false,
        contentType: false,
        processData: false,
      });
    });

    function limparCamposItens() {
      $('#texto_item').val('');
      $('#limite_itens').val('');
      $('#valor_do_item').val('');
    }

    function listarItens(id) {
      $.ajax({
        url: 'pages/produtos/listar-itens.php',
        method: 'POST',
        data: { id },
        dataType: "html",
        success: function (result) {
          $("#listar-itens").html(result);
          $('#mensagem-excluir-itens').text('');
        }
      });
    }

    function excluirItens(id) {
      var id_var = $('#id_item').val();
      $.ajax({
        url: 'pages/produtos/excluir-item.php',
        method: 'POST',
        data: { id },
        dataType: "text",
        success: function (mensagem) {
          if (mensagem.trim() == "Excluído com Sucesso") {
            listarItens(id_var);
          } else {
            $('#mensagem-excluir-itens').addClass('text-danger');
            $('#mensagem-excluir-itens').text(mensagem);
          }
        }
      });
    }

    function ativarItens(id, acao) {
      var id_var = $('#id_item').val();
      $.ajax({
        url: 'pages/produtos/mudar-status-itens.php',
        method: 'POST',
        data: { id, acao },
        dataType: "text",
        success: function (mensagem) {
          if (mensagem.trim() == "Alterado com Sucesso") {
            listarItens(id_var);
          } else {
            $('#mensagem-excluir-itens').addClass('text-danger');
            $('#mensagem-excluir-itens').text(mensagem);
          }
        }
      });
    }
  </script>

  <script type="text/javascript">
    $(document).ready(function () {
      $('.sel2').select2({
        dropdownParent: $('#modalForm')
      });

      $('.sel5').select2({
        dropdownParent: $('#modalItens')
      });
    });
  </script>

  <script type="text/javascript">
    function listarVarCat(id) {
      $.ajax({
        url: 'pages/produtos/listar_var_cat.php',
        method: 'POST',
        data: { id },
        dataType: "html",
        success: function (result) {
          $("#listar_var_cat").html(result);
        }
      });
    }
  </script>

  <script type="text/javascript">
    function alterarValor() {
      var adicional = $('#adicional_grade').val();
      var e_adicional = $('#e_adicional').val();

      if (e_adicional == 'Não') {
        return;
      }

      $.ajax({
        url: 'pages/produtos/listar_valor_adicional.php',
        method: 'POST',
        data: { adicional },
        dataType: "html",
        success: function (result) {
          $("#valor_do_item").val(result);
        }
      });
    }
  </script>
</body>

</html>

<style>
  /* Modal Background */
  .modal.fade .modal-dialog {
    transition: transform 0.3s ease-out, opacity 0.3s ease-out;
  }

  .modal.fade.show .modal-dialog {
    transform: scale(1.05);
  }

  .modal-content {
    border-radius: 10px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
    overflow: hidden;
  }

  /* Header Style */
  .modal-header {
    background: linear-gradient(90deg, #007bff, #0056b3);
    color: white;
    padding: 1.5rem;
    border-bottom: none;
  }

  .modal-header .modal-title {
    font-weight: 600;
    font-size: 1.3rem;
  }

  .modal-header .close {
    font-size: 1.5rem;
    outline: none;
  }

  /* Modal Body Styling */
  .modal-body {
    padding: 1.5rem;
    font-family: Arial, sans-serif;
    font-size: 1rem;
    color: #333;
  }

  /* Rows and Columns */
  .modal-body .row {
    margin-bottom: 1rem;
  }

  .modal-body span {
    font-weight: 500;
    color: #666;
  }

  .modal-body b {
    font-weight: 600;
    color: #444;
  }

  /* Image Styling */
  .modal-body img#target_mostrar {
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
  }

  /* Close Button Hover Effect */
  .modal-header .close:hover {
    color: #ccc;
    transform: scale(1.1);
    transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
  }
</style>