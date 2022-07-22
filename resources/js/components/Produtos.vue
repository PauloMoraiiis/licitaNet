<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
               <!-- Início do card de busca -->
                <card-component titulo="Busca de Produtos">
                  <template v-slot:conteudo>
                     <div class="form-row">
                           <div class="col mb-3">
                              <input-container-component titulo="ID" id="inputId" id-help="idHelp" textoAjuda="Informe o Id do produto">
                                 <input type="number" class="form-control" id="inpuId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                              </input-container-component>
                           </div>
                           <div class="col mb-3">

                              <input-container-component titulo="Nome do produto" id="inputNome" id-help="nomeHelp" textoAjuda="Informe o nome do produto">
                                 <input type="text" class="form-control" id="inpuNome" aria-describedby="nomeHelp" placeholder="Nome do produto" v-model="busca.nome">
                              </input-container-component>
                           </div>
                        </div>
                  </template>
                  <template v-slot:rodape>
                      <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                  </template>
                </card-component>
                 <!-- Fim do card de busca -->

                 <!-- Início do card de listagem de produtos -->
                <card-component titulo="Lista de produtos">
                  <template v-slot:conteudo>
                     <table-component 
                        :dados="produtos.data"
                        :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalProdutoVisualizar'}"
                        :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalProdutoAtualizar'}"
                        :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalProdutoRemover'}"
                        :titulos="['Id', 'Código', 'Nome', 'Cidade', 'Valor', 'Estoque']" 
                        :cidades="cidades">
                     </table-component>
                  </template>
                  <template v-slot:rodape>
                     <div class="row">
                        <div class="col-10">
                           <paginate-component>
                              <li v-for="l, key in produtos.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                 <a class="page-link" v-html="l.label"></a></li>
                           </paginate-component>
                        </div>
                        <div class="col">
                           <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalProduto">Adicionar</button>
                        </div>
                  </div>
                  </template>
                </card-component>
                <!-- Fim do card de listagem de produtos -->
            </div>
        </div>

        <!-- Início do modal de inclusão de produto -->
        <modal-component id="modalProduto" titulo="Adicionar produto">
         <!-- Alertas -->
            <template v-slot:alertas>
               <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo='Cadastro realizado com sucesso' v-if="transacaoStatus == 'adicionado'"></alert-component>
               <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo='Erro ao tentar cadastrar o produto' v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
               <div class="form-group">
                  <input-container-component titulo="Nome do produto" id="novoNome" id-help="novoNomeHelp" textoAjuda="Informe o nome do produto">
                     <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome do produto" v-model="nomeProduto">
                  </input-container-component>
               </div>

               <div class="form-group">
                  <input-container-component titulo="Código do produto" id="novoCod" id-help="novoCodHelp" textoAjuda="Informe o código do produto">
                     <input type="number" class="form-control" id="novoCod" aria-describedby="novoCodHelp" placeholder="Código" v-model="codProduto">
                  </input-container-component>
               </div>

               <div class="form-group">
                  <input-container-component titulo="Quantidade em estoque" id="estoqueNovo" id-help="estoqueNovoHelp" textoAjuda="Informe a quantidade em estoque">
                     <input type="number" class="form-control" id="novoEstoque" aria-describedby="estoqueNovoHelp" placeholder="Quantidade" v-model="quantidadeProduto">
                  </input-container-component>
               </div>

               <div class="form-group">
                  <input-container-component titulo="Valor do produto" id="valorNovo" id-help="valorNovoHelp" textoAjuda="Informe o valor do produto">
                     <input type="number" class="form-control" id="novoValor" aria-describedby="valorNovoHelp" placeholder="Valor em Reais" v-model="valorProduto">
                  </input-container-component>
               </div>

               <div class="form-group">
                  <label for="inputState">Cidade</label>
                  <select id="inputState" class="form-control" v-model="cidadeProduto">
                     <option selected>Selecione uma cidade</option>
                     <option v-for="c in cidades" :key="c.id" :value="c.id">{{c.nome}}</option>
                  </select>
               </div>
            </template>
            <!--Botões-->
            <template v-slot:rodape>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
               <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
        <!-- Final do modal de inclusão de produto -->

        <!-- Inicio do modal de visualização de produto -->
        <modal-component id="modalProdutoVisualizar" titulo="Vizualizar produto">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>
               <input-container-component titulo="ID">
                  <input type="text" class="form-control" :value="$store.state.item.id" disabled>
               </input-container-component>
               <input-container-component titulo="Código">
                  <input type="text" class="form-control" :value="$store.state.item.cod" disabled>
               </input-container-component>
               <input-container-component titulo="Nome">
                  <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
               </input-container-component>
               <input-container-component titulo="Valor">
                  <input type="text" class="form-control" :value="$store.state.item.valor" disabled>
               </input-container-component>
               <input-container-component titulo="Cidade">
                  <input type="text" class="form-control" v-if="$store.state.item.cidade" :value="$store.state.item.cidade.nome" disabled>
               </input-container-component> 
               <input-container-component titulo="Data de criação">
                  <input type="text" class="form-control" :value="$store.state.item.created_at | formataDataTempo" disabled>
               </input-container-component>      
               <input-container-component titulo="Data de alteração">
                  <input type="text" class="form-control" :value="$store.state.item.updated_at | formataDataTempo" disabled>
               </input-container-component>      
            </template>
            <template v-slot:rodape>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!-- Final do modal de visualização de produto -->

        <!-- Inicio do modal de remoção de produto -->
        <modal-component id="modalProdutoRemover" titulo="Remover produto">
            <template v-slot:alertas>
               <alert-component tipo="success" titulo="Transaçáo realizazda com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
               <alert-component tipo="danger" titulo="Erro na transaçáo" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'" ></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
               <input-container-component titulo="ID">
                  <input type="text" class="form-control" :value="$store.state.item.id" disabled>
               </input-container-component>
               <input-container-component titulo="Código">
                  <input type="text" class="form-control" :value="$store.state.item.cod" disabled>
               </input-container-component>
               <input-container-component titulo="Nome">
                  <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
               </input-container-component>     
            </template>
            <template v-slot:rodape>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
               <button type="button" class="btn btn-danger" data-dismiss="modal" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>
        </modal-component>
        <!-- Final do modal de remoção de produto -->

         <!-- Início do modal de atualização de produto -->
        <modal-component id="modalProdutoAtualizar" titulo="Atualizar produto">
         <!-- Alertas -->
            <template v-slot:alertas>
               <alert-component tipo="success" titulo="Transaçáo realizazda com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
               <alert-component tipo="danger" titulo="Erro na transaçáo" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'" ></alert-component>
            </template>

            <template v-slot:conteudo>
               <div class="form-group">
                  <input-container-component titulo="Nome do produto" id="atualizarNome" id-help="atualizarNomeHelp" textoAjuda="Informe o nome do produto">
                     <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome do produto" v-model="$store.state.item.nome">
                  </input-container-component>
               </div>

               <div class="form-group">
                  <input-container-component titulo="Código do produto" id="atualizarCod" id-help="atualizarCodHelp" textoAjuda="Informe o código do produto">
                     <input type="number" class="form-control" id="atualizarCod" aria-describedby="atualizarCodHelp" placeholder="Código" v-model="$store.state.item.cod">
                  </input-container-component>
               </div>

               <div class="form-group">
                  <input-container-component titulo="Quantidade em estoque" id="atualizarEstoque" id-help="atualizarEstoqueHelp" textoAjuda="Informe a quantidade em estoque">
                     <input type="number" class="form-control" id="atualizarEstoque" aria-describedby="atualizarEstoqueHelp" placeholder="Quantidade" v-model="$store.state.item.estoque">
                  </input-container-component>
               </div>

               <div class="form-group">
                  <input-container-component titulo="Valor do produto" id="atualizaValor" id-help="atualizarValorHelp" textoAjuda="Informe o valor do produto">
                     <input type="number" class="form-control" id="atualizarValor" aria-describedby="atualizarValorHelp" placeholder="Valor em Reais" v-model="$store.state.item.valor">
                  </input-container-component>
               </div>

               <div class="form-group">
                  <label for="inputState">Cidade</label>
                  <select id="inputState" class="form-control" v-model="$store.state.item.cidade_id">
                     <option selected>Selecione uma cidade</option>
                     <option v-for="c in cidades" :key="c.id" :value="c.id">{{c.nome}}</option>
                  </select>

               </div>
               

            </template>
            <!--Botões-->
            <template v-slot:rodape>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
               <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>
        </modal-component>
        <!-- Final do modal de atualização de produto -->
      </div>
</template>

<script>
import axios from 'axios'

   export default{

      data() {
         return {
            urlBase: 'http://127.0.0.1:8000/api/produto',
            urlCidade: 'http://127.0.0.1:8000/api/cidade',
            urlPaginacao: '',
            urlFiltro: '',
            nomeProduto: '',
            codProduto: '',
            idProduto: '',
            quantidadeProduto: '',
            valorProduto: '',
            cidadeProduto: '',
            transacaoStatus: '',
            transacaoDetalhes: {},
            produtos: [],
            cidades: {},
            busca: {id: '', nome: ''}
         }
      },
      methods: {
         atualizar() {

            let formData = new FormData();
            formData.append('_method', 'patch')
            formData.append('nome', this.$store.state.item.nome)
            formData.append('cod', this.$store.state.item.cod)
            formData.append('estoque', this.$store.state.item.estoque)
            formData.append('valor', this.$store.state.item.valor)
            formData.append('cidade_id', this.$store.state.item.cidade_id)

            let url = this.urlBase + '/' + this.$store.state.item.id

            let config = {
               headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
                  'Accept': 'application/json'
               }
            }

            axios.post(url, formData, config)
               .then(response => {
                  this.$store.state.transacao.status = 'sucesso'
                  this.$store.state.transacao.mensagem = 'Registro atualizado com sucesso'
                  this.carregarLista()
               })
               .catch(errors => {
                  this.$store.state.transacao.status = 'erro'
                  this.$store.state.transacao.mensagem = errors.response.data.message
                  this.$store.state.transacao.dados = errors.response.data.errors
               })

         },

         remover() {
            let confirmacao = confirm('Tem certeza que deseja remover esse registro?')

            if(!confirmacao) {
               return false;
            }
   
            let formData = new FormData();
            formData.append('_method', 'delete')

            let config = {
               headers: {
                  'accept': 'application/json'
               }
            }

            let url = this.urlBase + '/' + this.$store.state.item.id

            axios.post(url, formData, config)
               .then(response => {
                  this.$store.state.transacao.status = 'sucesso'
                  this.$store.state.transacao.mensagem = response.data.msg
                  this.carregarLista()
               })
               .catch(errors => {
                  this.$store.state.transacao.status = 'erro'
                  this.$store.state.transacao.mensagem = errors.response.data.errors
               })
         },

         pesquisar() {
            
            let filtro = ''

            for(let chave in this.busca) {

               if(this.busca[chave]) {

                  if(filtro != '') {
                     filtro += ";"
                  }
                  if(chave == 'nome') {
                     filtro += chave + ':like:' + '%' + this.busca[chave] + '%'
                  } else {
                     filtro += chave + ':like:' + this.busca[chave]
                  }
               }
            }
            if(filtro != '') {

               this.urlPaginacao = 'page=1'
               this.urlFiltro = '&filtro='+filtro
            } else {
               this.urlFiltro = ''
            }
            this.carregarLista()
         },

         paginacao(l) {
            if(l.url) {
               //this.urlBase = l.url  //ajustando a url de consulta comparâmetros de página
               this.urlPaginacao = l.url.split('?')[1]
            this.carregarLista() //requisitando novamente os dados para API
            }
         },

         carregarLista() {

            let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
            axios.get(url)
               .then(response => {
                  this.produtos = response.data
               })
               .catch(errors => {
                  console.log(errors)
               })
         },

         carregarCidades() {
            axios.get(this.urlCidade)
               .then(response => {
                  this.cidades = response.data
                  //console.log(this.cidades);
               })
               .catch(errors => {
                  console.log(errors)
               })

         },

         salvar() {
            let formData = new FormData()
            formData.append('id', this.idProduto)
            formData.append('cidade_id', this.cidadeProduto)
            formData.append('cod', this.codProduto)
            formData.append('nome', this.nomeProduto)
            formData.append('valor', this.valorProduto)
            formData.append('estoque', this.quantidadeProduto)
            
            let config = {
               method: 'POST',
               headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
                  'Accept': 'application/json'
               }
            }
            axios.post(this.urlBase, formData, config)
               .then(response => {
                  this.transacaoStatus = 'adicionado'
                  this.transacaoDetalhes = {
                     mensagem: 'Id do produto: ' + response.data.id
                  }
                  console.log(response)
               })
               .catch(errors => {
                  this.transacaoStatus = 'erro'
                  this.transacaoDetalhes = {
                     mensagem: errors.response.data.message,
                     dados: errors.response.data.errors
                  } 
                  //error.response.data.message)
               });
         },         
      },

      mounted() {
         this.carregarLista()
         this.carregarCidades()
      }
   }

</script>
