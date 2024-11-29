<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-bullhorn"></i>
            Atualizações
        </h3>
    </div>
    <div class="card-body">
        <div class="callout callout-warning">
            <h5>Implementado Declarações Preparadas para alterações do BD</h5>
            <p>
                Versão: 2.8.2-beta (teste);<br />
                Locais: modelo mConexao;<br />
                Campo: --;<br />
                Data: 28/11/2024;<br />                
                Descrição: Alterado lógica do modelo, atendendo a versão 8.2 da linguagem PHP.<br />                
            </p>
        </div>
        <div class="callout callout-info">
            <h5>Implementação de ícone de copiar</h5>
            <p>
                Versão: 2.8.2-beta (teste);<br />
                Locais: tela 2_1_1;<br />
                Campo: e-mail;<br />
                Data: 12/11/2024;<br />                
                Descrição: Implementado ícone e alterado algorítmo para copiar e-mail.<br />                
            </p>
        </div>
        <div class="callout callout-warning">
            <h5>Resolução de bug</h5>
            <p>
                Versão: 2.8.2-beta (teste);<br />
                Locais: tela 2_1_1;<br />
                Campo: descricao;<br />
                Data: 11/11/2024;<br />                
                Descrição: Limitado a quantidade de caracteres do campo para 240.<br />                
            </p>
        </div>
        <div class="callout callout-warning">
            <h5>Método get para recuperação de senha</h5>
            <p>
                Versão: 2.8.2-beta (teste);<br />
                Locais: tela tAlterarSenha;<br />
                Campo: seguranca;<br />
                Data: 08/11/2024;<br />                
                Descrição: Implementado str_replace para substituição do "espaço" por "+".<br />                
            </p>
        </div>
        <div class="callout callout-warning">
            <h5>Implementado Declarações Preparadas para consultas do BD</h5>
            <p>
                Versão: 2.8.2-beta (teste);<br />
                Locais: modelo mConexao;<br />
                Campo: --;<br />
                Data: 07/11/2024;<br />                
                Descrição: Alterado lógica do modelo, atendendo a versão 8.2 da linguagem PHP.<br />                
            </p>
        </div>
        <div class="callout callout-warning">
            <h5>Credencial do usuário</h5>
            <p>
                Versão: 2.8.2-beta (teste);<br />
                Locais: controladores sCargo, sCoordenacao, sDepartamento, sEmail, sPermissao, sSecretaria, sSenha, sSetor, sTelefone, sUsuario;<br />
                Campo: --;<br />
                Data: 29/10/2024;<br />                
                Descrição: Alterado lógica dos controladores, removendo INNER_JOIN e implementando 2 consultas.<br />                
            </p>
        </div>
        <div class="callout callout-info">
            <h5>Alterar dados dos locais</h5>
            <p>
                Versão: 2.8.2-beta (teste);<br />
                Locais: telas 4_2_1, 4_2_2, 4_2_3, 4_2_4, 4_2_1_1, 4_2_2_1, 4_2_3_1, 4_2_4_1;<br />
                Campos: Secretaria, Departamento, Coordenação, Setor, Endereço, E-mail, Ambiente, Telefone, WhatsApp;<br />
                Data: 24/10/2024;<br />                
                Descrição: Implementado menus e telas até 4 níveis para alterar os dados dos locais.<br />                
            </p>
        </div>
        <div class="callout callout-warning">
            <h5>Correção de bug (Multibyte String)</h5>
            <p>
                Versão: 2.8.2-beta (teste);<br />
                Locais: telas 2_2 e 2_2_1;<br />
                Campo: Solicitante;<br />
                Data: 17/10/2024;<br />                
                Descrição: Alterado lógica do algoritmo, ao invés de comparar nome do requerente com solicitante, comparar e-mail do requerente com solicitante.<br />                
            </p>
        </div>
        <div class="callout callout-info">
            <h5><s>Alterado tempo limite do Garbage Collector</s></h5>
            <p>
                Versão: 2.8.2-beta (teste);<br />
                Local: tela tAcessar.php;<br />
                Campo: --;<br />
                Data: 15/10/2024;<br />                
                Descrição: Alterado tempo limite do GC para 6h.<br />                
            </p>
        </div>
        <div class="callout callout-info">
            <h5>Implementado segurança de cookie</h5>
            <p>
                Versão: 2.8.2-beta (teste);<br />
                Local: tela tAcessar.php;<br />
                Campo: --;<br />
                Data: 14/10/2024;<br />                
                Descrição: Habilitado HttpOnly.<br />                
            </p>
        </div>
        <div class="callout callout-info">
            <h5>Alterar dados dos outros usuários</h5>
            <p>
                Versão: 2.8.2-beta (teste);<br />
                Local: Perfil->Outros Usuários->Editar;<br />
                Campos: Nome, Sobrenome, Sexo, Telefone, WhatsApp, E-mail, Permissão, Cargo, Secretaria, Departamento, Coordenação, Setor, Situação;<br />
                Data: 11/10/2024;<br />                
                Descrição: Implementado backend da tela 1_2_1.<br />                
            </p>
        </div>
        <div class="callout callout-info">
            <h5>Botão de contato</h5>
            <p>
                Versão: 2.8.2-beta (teste);<br />
                Local: Barra de menus (top);<br />
                Campo: Conversa via WhatsApp;<br />
                Data: 08/10/2024;<br />                
                Descrição: Incrementado link de redirecionamento para conversa via WhatsApp.<br />                
            </p>
        </div>
        <div class="callout callout-info">
            <h5>Link de contato</h5>
            <p>
                Versão: 2.8.2-beta (teste);<br />
                Local: Barra de Menus (lateral) Suporte->Acompanhar->Visualizar;<br />
                Campo: Telefone;<br />
                Data: 08/10/2024;<br />                
                Descrição: Incrementado link de redirecionamento para conversa via WhatsApp.<br />                
            </p>
        </div>
    </div>
</div>

<!--
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>1</h3>
                    <p>Atendimentos Aguardando</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Mais Informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>2</h3>
                    <p>Atendimentos Em Andamento</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">Mais Informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>1</h3>
                    <p>Atendimentos Finalizados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Mais Informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>
-->