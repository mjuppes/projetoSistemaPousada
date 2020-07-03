<%@ Page Title="" Language="C#" MasterPageFile="~/MasterPage.Master" AutoEventWireup="true" CodeBehind="Pacientes.aspx.cs" Inherits="ProjetoClinica.Pages.Cadastros" %>
<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
  <!-- Menu -->
  <div id="menu">
  <div class="side">
    <nav class="dr-menu">
	  <div class="dr-trigger"><span class="dr-icon dr-icon-menu"></span><a class="dr-label"><asp:Label ID="lblPacient" runat="server" Text="Pacientes"></asp:Label></a></div>
		<ul>
		  <li><a class="link" id="idRegP"  href="../Pages/Pacientes.aspx#lista-pacientes"><asp:Label ID="lblTodosR" runat="server" Text="Todos Registros"></asp:Label></a></li>
		  <li><a class="link" id="idCadP"  href="../Pages/Pacientes.aspx?Acao=Cadastrar#cad-paciente"><asp:Label ID="lblCadPac" runat="server" Text="Cadastrar Peciente"></asp:Label></a></li>	
          <li><a class="link" id="idSenha" href="../Pages/Cadastrar-usuario.aspx?id=<%=Session["id_usu"]%>"><asp:Label ID="lblAlteraS" runat="server" Text="Alterar Senha"></asp:Label></a></li>
		  <li><a class="dr-icon dr-icon-switch link" id="idLogout"  href="../Pages/Pacientes.aspx?Acao=Logout"><asp:Label ID="lblLogout" runat="server" Text="Logout"></asp:Label></a></li>
	    </ul>
	  </nav>
    </div>
    <script src="../js/ytmenu.js"></script>
  </div>
  <!-- Formulario -->
  <div id="frm-paciente">
  <div>
    <img id="usuario" src="../img/usuario_.png" runat="server" width="34"/>&nbsp;
    <asp:Label ID="lblUsuario" CssClass="usuario-logado" runat="server" Text="Usuário: "></asp:Label><asp:Label ID="lblUsuLogado" runat="server" CssClass="font-style"></asp:Label>
  </div>
  <!-- -->

  <!-- Tabs -->
  <div id="tabs">
    <ul>
      <li><a class="click" href="#lista-pacientes" id="lista-paci"><asp:Label ID="lblTodos" Text="Todos Registros" runat="server"></asp:Label></a></li>
      <li><a class="click" href="#cad-paciente"    id="cadastrar"><asp:Label ID="lblCadPa" runat="server"></asp:Label></a></li>
      <li>
        <div class="sarch">
          <asp:TextBox ID="txtSarch" CssClass="sarch" Width="200px" placeholder="Nome Paciente..."  runat="server"></asp:TextBox>
          <asp:Button ID="btnBuscar" CssClass="estyle-buscar" style="height:26px"  runat="server" Text="Buscar" OnClientClick="fValidaPesquisa()" OnClick="btnBuscar_Click" />
        </div>
      </li>
    </ul>  
    <!-- Todos os Registros -->
    <div id="lista-Paciente">
      <div id="lista-pacientes" class="scroll-paciente">
        <asp:GridView ID="grdPaciente" runat="server" OnRowDataBound="grdPaciente_RowDataBound" ForeColor="#333333" GridLines="None" AutoGenerateColumns="False" Width="860px" CssClass="gridview" CellPadding="4" OnRowCommand="grdPaciente_RowCommand">
            <AlternatingRowStyle BackColor="White" />
            <Columns>          
              <asp:BoundField DataField="nome"     HeaderText="Nome"       ReadOnly="True" SortExpression="nome"/>
              <asp:BoundField DataField="contato"  HeaderText="Contato"    ReadOnly="True" SortExpression="contato"/>
              <asp:BoundField DataField="dta_nasc" HeaderText="Data Nasc." ReadOnly="True" SortExpression="dta_nasc" DataFormatString="{0:dd/MM/yyyy}"/>
              <asp:BoundField DataField="endereco" HeaderText="Endereço"   ReadOnly="True" SortExpression="endereco"/>
              <asp:BoundField DataField="cep"      HeaderText="CEP"        ReadOnly="True" SortExpression="cep"/>
              <asp:BoundField DataField="bairro"   HeaderText="Bairro"     ReadOnly="True" SortExpression="bairro"/>
              <asp:BoundField DataField="cidade"   HeaderText="Cidade"     ReadOnly="True" SortExpression="cidade"/>
              <asp:TemplateField>   
                <ItemTemplate>
                  &nbsp;&nbsp;<asp:LinkButton ID="consultas" runat="server" Text="Agenda" CommandName="Agenda" ToolTip="Consultas" CommandArgument='<%# Eval("id_pac")%>'><img src="../img/xxx.png"/></asp:LinkButton>&nbsp;&nbsp;
                  &nbsp;<asp:LinkButton ID="editar" runat="server" Text="Editar" CommandName="Editar" ToolTip="Editar" CommandArgument='<%# Eval("id_pac")%>'><img src="../img/icon_edit.png" /></asp:LinkButton>&nbsp;
                  &nbsp;&nbsp;<asp:LinkButton ID="excluir" runat="server" Text="Excluir" CommandName="Deletar" ToolTip="Excluir" CommandArgument='<%# Eval("id_pac")%>' OnClientClick='return confirm("Deseja deletar este Cliente? ");'><img src="../img/teste_delete.png" /></asp:LinkButton>&nbsp;
                </ItemTemplate>
              </asp:TemplateField>
            </Columns>
            <EditRowStyle BackColor="#2461BF" />
            <FooterStyle BackColor="#507CD1" ForeColor="White" Font-Bold="True" />
            <HeaderStyle BackColor="#000000" Font-Bold="True" ForeColor="White" />
            <PagerStyle BackColor="#2461BF" ForeColor="White" HorizontalAlign="Center" />
            <RowStyle BackColor="#EFF3FB" />
            <SelectedRowStyle BackColor="#D1DDF1" Font-Bold="True" ForeColor="#333333" />
            <SortedAscendingCellStyle BackColor="#F5F7FB" />
            <SortedAscendingHeaderStyle BackColor="#6D95E1" />
            <SortedDescendingCellStyle BackColor="#E9EBEF" />
            <SortedDescendingHeaderStyle BackColor="#4870BE" />
        </asp:GridView> 
      </div>
    </div>   
                   	  
    <!--   Cadastro de Usuarios  -->
    <div id="cad-paciente">
      <div id="frm-cad-paciente">
        <table border="0" id="tabela" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 12px;">
          <tr>
            <td colspan="2" class="titulo">
              <asp:Label ID="lblTitulo" runat="server" ></asp:Label>
            </td>
          </tr>
          <tr>
            <td class="position-label"><asp:Label ID="lblNome" runat="server" Text="Nome "></asp:Label>&rarr;</td>
            <td>
              <asp:TextBox ID="txtNome" required="required"  Width="300px" runat="server"></asp:TextBox>
              <asp:Label ID="Label5" CssClass="style-ast" runat="server" Text=" * "></asp:Label>
            </td>    
          </tr>
          <tr>
            <td class="position-label"><asp:Label ID="lblContato" runat="server" Text="Contato "></asp:Label>&rarr;</td>
            <td>
              <asp:TextBox ID="txtContato"  ClientIDMode="Static"  Width="108px" runat="server"></asp:TextBox>&nbsp;<img class="contato" src="../img/telefone.png" height="19" title="Agendar consulta" runat="server" />
              <asp:Label ID="Label1" CssClass="style-ast" runat="server" Text=" * "></asp:Label>
            </td>
          </tr>
          <tr class="compl-cad">
            <td class="position-label"><asp:Label ID="lblDtanacs" runat="server" Text="Data Nasc."></asp:Label>&rarr;</td>
            <td>
              <asp:TextBox ID="txtDataNasc" required="required"  Width="79px" runat="server"></asp:TextBox>
              <asp:Label ID="Label2" CssClass="style-ast" runat="server" Text=" * "></asp:Label>
            </td>
          </tr>
          <asp:ScriptManager ID="ScriptManager1" runat="server"></asp:ScriptManager>     
          <tr class="compl-cad">
            <td class="position-label"><asp:Label ID="lblEstado" runat="server" Text="UF "></asp:Label>&rarr;</td>
            <td>
              <asp:DropDownList ID="dropUF" runat="server" AutoPostBack="true" OnSelectedIndexChanged="dropUF_SelectedIndexChanged" ></asp:DropDownList>
              <asp:Label ID="Label8" CssClass="style-ast" runat="server" Text=" * "></asp:Label>
            </td>
          </tr>
          <tr class="compl-cad">
            <td class="position-label"><asp:Label ID="lblCidade" runat="server" Text="Cidade "></asp:Label>&rarr;</td>
            <td>
              <asp:UpdatePanel ID="upCidade" runat="server" UpdateMode="Conditional">
                <ContentTemplate>
                  <asp:DropDownList ID="dropCidade" runat="server" Width="240" OnSelectedIndexChanged="dropCidade_SelectedIndexChanged">
                    <asp:ListItem></asp:ListItem>
                  </asp:DropDownList>
                  <asp:Label ID="Label9" CssClass="style-ast" runat="server" Text=" * "></asp:Label>
                </ContentTemplate>
                <Triggers>
                  <asp:AsyncPostBackTrigger ControlID="dropUF" EventName="SelectedIndexChanged" />
                </Triggers>
              </asp:UpdatePanel> 
            </td>
          </tr>
          <tr class="compl-cad">
            <td class="position-label"><asp:Label ID="lblEnd" runat="server" Text="Endereço"></asp:Label>&rarr;</td>
            <td>
              <asp:TextBox ID="txtEnd" required="required"  Width="300px" runat="server"></asp:TextBox>
              <asp:Label ID="Label3" CssClass="style-ast" runat="server" Text=" * "></asp:Label>
            </td>
          </tr>
          <tr class="compl-cad">
            <td class="position-label"><asp:Label ID="lblNum" runat="server" Text="Numero "></asp:Label>&rarr;</td>
            <td>
              <asp:TextBox ID="txtNum" required="required"  Width="50px" runat="server"></asp:TextBox>
              <asp:Label ID="Label4" CssClass="style-ast" runat="server" Text=" * "></asp:Label>
            </td>
          </tr>
          <tr class="compl-cad">
            <td class="position-label"><asp:Label ID="lblBairro" runat="server" Text="Bairro "></asp:Label>&rarr;</td>
            <td>
              <asp:TextBox ID="txtBairro" required="required"  Width="200px" runat="server"></asp:TextBox>
              <asp:Label ID="Label7" CssClass="style-ast" runat="server" Text=" * "></asp:Label>
            </td>
          </tr>
          <tr class="compl-cad">
            <td class="position-label"><asp:Label ID="lblCep" runat="server" Text="CEP "></asp:Label>&rarr;</td>
            <td>
              <asp:TextBox ID="txtCep" required="required"  ClientIDMode="Static"  Width="80px" runat="server"></asp:TextBox>
              <asp:Label ID="Label6" CssClass="style-ast" runat="server" Text=" * "></asp:Label>
            </td>
          </tr> 
          <tr>
            <td colspan="2" style="text-align:center;padding-top:8px">
              <asp:Label ID="Label10" runat="server" Text="Campos com ( * ) são obrigatório"></asp:Label>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:right" >
              <asp:Button ID="btnIncPaciente" CssClass="estyle-botton" runat="server" Text="Incluir" OnClientClick="fIncluirPre()" OnClick="btnIncPaciente_Click"   />
              <asp:Button ID="btnCanPaciente" CssClass="estyle-botton" runat="server" Text="Cancelar" />
            </td>
          </tr>
          <tr>
            <td><asp:Label ID="msg" runat="server"></asp:Label></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

    /* DataPicker */
    $(document).ready(function () {
      $("[id$=txtDataNasc]").datepicker({
        showOn: "button",
        buttonImage: "../css/themes/smoothness/images/calendar.gif",
        buttonImageOnly: true
      });
    });

    /* Macara para Contato e CEP */
    $(document).ready(function () {
      $("#txtContato").mask("(99)9999-9999");
      $("#txtCep").mask("99999-999");
    });

    /* Valida Campo Buscar */
    function fValidaPesquisa() {

      var InputBuscar = document.getElementById('<%=txtSarch.ClientID%>');

      var InputNome     = document.getElementById('<%= txtNome.ClientID%>');
      var InputContato  = document.getElementById('<%= txtContato.ClientID%>');
      var InputDataNasc = document.getElementById('<%= txtDataNasc.ClientID%>');
      var InputEnd      = document.getElementById('<%= txtEnd.ClientID%>');
      var InputNum      = document.getElementById('<%= txtNum.ClientID%>');
      var InputCep      = document.getElementById('<%= txtCep.ClientID%>');
      var InputBairro   = document.getElementById('<%= txtBairro.ClientID%>');

      InputNome.required     = "";
      InputContato.required  = "";
      InputDataNasc.required = "";
      InputEnd.required      = "";
      InputNum.required      = "";
      InputCep.required      = "";
      InputBairro.required   = "";

      if (InputBuscar.value == "") {
        alert("O campo Nome Paciente... Deve estar Preenchido!!!");
        return false;
      }
    }

    function fIncluirPre() {
    
        var InputNome     = document.getElementById('<%= txtNome.ClientID%>');
        var InputContato  = document.getElementById('<%= txtContato.ClientID%>');
        var InputDataNasc = document.getElementById('<%= txtDataNasc.ClientID%>');
        var InputEnd      = document.getElementById('<%= txtEnd.ClientID%>');
        var InputNum      = document.getElementById('<%= txtNum.ClientID%>');
        var InputCep      = document.getElementById('<%= txtCep.ClientID%>');
        var InputBairro   = document.getElementById('<%= txtBairro.ClientID%>');

        InputNome.required     = "";
        InputContato.required  = "";
        InputDataNasc.required = "";
        InputEnd.required      = "";
        InputNum.required      = "";
        InputCep.required      = "";
        InputBairro.required   = "";

    }
 </script>
</asp:Content>
