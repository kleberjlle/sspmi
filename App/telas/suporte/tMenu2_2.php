<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Etapa - Outros Usuários</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tabelaMenu1_2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Protocolo n.º</th>
                    <th>Data e Hora</th>
                    <th>Solicitante</th>
                    <th>Telefone</th>
                    <th>Patrimônio/ Identificação</th>
                    <th>Categoria/ Marca/ Modelo</th>
                    <th>Descrição</th>
                    <th>Ambiente</th>
                    <th>Local</th>
                    <?php    
                    if($_SESSION['permissao'] > 1){
                    echo <<<HTML
                        <th>Prioridade</th>
HTML;
                        }
                        ?>
                    <th>Atribuir/ Visualizar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($_SESSION['permissao'] > 1 || $_SESSION['email'] == 'usuario@gmail.com'){
                   echo <<<HTML
                <tr>
                    <td>20230001</td>
                    <td>19/12/2023 9:27</td>
                    <td>
                        João Fictício<br />
                        por <i>Kleber Pereira de Almeida</i></td>
                    <td>
                        <i class="fas fa-building mr-1"></i>(47) 3443-8832<br />
                        <i class="fas fa-building mr-1"></i>(47) 3443-8864<br />
                        <i class="fas fa-user-alt mr-1"></i>(47) 9 9999-9999<br />
                        <i class="fas fa-building mr-1"></i>(47) 9 8827-2029</td>
                    <td>28000</td>
                    <td>Computador Dell OptPlex Micro 7010</td>
                    <td>Sem conexão</td>
                    <td>Interno</td>
                    <td>Prateleira</td>
HTML;
                   if($_SESSION['permissao'] > 1){
                       echo <<<HTML
                    <td>
                        <i class="nav-icon fas fa-flag text-orange"></i><br />
                        Muito Urgente
                    </td>
HTML;
                        }
                        echo <<<HTML
                    <td>
                        <a href="tPainel.php?menu=2_2_1&id=1">
                            <i class="fas fa-search mr-1"></i>
                        </a>
                    </td>
                </tr>
HTML;               
                }
                
                if($_SESSION['permissao'] > 1 || $_SESSION['email'] != 'usuario@gmail.com'){
                    echo <<<HTML
                <tr>
                    <td>20230002</td>
                    <td>10/12/2023 10:02</td>
                    <td>Kleber Pereira de Almeida</td>
                    <td>
                        <i class="fas fa-building mr-1"></i>(47) 3443-8832<br />
                        <i class="fas fa-building mr-1"></i>(47) 3443-8864<br />
                        <i class="fas fa-building mr-1"></i>(47) 9 8827-2029
                    </td>
                    <td>28530</td>
                    <td>Monitor LG N/A</td>
                    <td>Sem imagem</td>
                    <td>Interno</td>
                    <td>Bancada 1</td>
HTML;
                   if($_SESSION['permissao'] > 1){
                       echo <<<HTML
                    <td>
                        <i class="nav-icon fas fa-flag text-green"></i><br />
                        Alta
                    </td>
HTML;
                        }
                        echo <<<HTML
                    <td>
                        <a href="tPainel.php?menu=2_2_1&id=1">
                            <i class="fas fa-search mr-1"></i>
                        </a>
                    </td>
                </tr>
HTML;               
                }
                      
                if($_SESSION['permissao'] > 1 || $_SESSION['email'] != 'usuario@gmail.com'){
                    echo <<<HTML
                <tr>
                    <td>20240003</td>
                    <td>11/03/2024 12:56</td>
                    <td>Kleber Pereira de Almeida</td>
                    <td>
                        <i class="fas fa-building mr-1"></i>(47) 3443-8832<br />
                        <i class="fas fa-building mr-1"></i>(47) 3443-8864<br />
                        <i class="fas fa-building mr-1"></i>(47) 9 8827-2029
                    </td>
                    <td>27000</td>
                    <td>Notebook</td>
                    <td>Conexão de rede fica caindo</td>
                    <td>Externo</td>
                    <td>Origem</td>
HTML;
                   if($_SESSION['permissao'] > 1){
                        echo <<<HTML
                    <td>
                        <i class="nav-icon fas fa-flag text-primary"></i><br />
                        Normal
                    </td>
HTML;
                        }
                        echo <<<HTML
                    <td>
                        <a href="tPainel.php?menu=2_2_1&id=1">
                            <i class="fas fa-search mr-1"></i>
                        </a>
                    </td>
                </tr>
HTML;               
                }
                    ?>   
                    
                    
            </tbody>
            <tfoot>
                <tr>
                    <th>Protocolo n.º</th>
                    <th>Data e Hora</th>
                    <th>Solicitante</th>
                    <th>Telefone</th>
                    <th>Patrimônio/ Identificação</th>
                    <th>Categoria/ Marca/ Modelo</th>
                    <th>Descrição</th>
                    <th>Ambiente</th>
                    <th>Local</th>
                    <?php    
                    if($_SESSION['permissao'] > 1){
                    echo <<<HTML
                        <th>Prioridade</th>
HTML;
                        }
                        ?>
                    <th>Atribuir/ Visualizar</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>