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
                        :atualizar={}
                        :remover={}
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
                     <option  v-for="c in cidades" :key="c.id" :value="c.id">{{c.nome}}</option>
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
            <template v-slot:conteudo>Teste</template>
            <template v-slot:rodape>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        
        <!-- Final do modal de visualização de produto -->
      </div>
</template>

<script>
import axios from 'axios'

   export default{
      data() {
         return {
            urlBase: 'http://127.0.0.1:8000/api/produto/',
            urlCidade: 'http://127.0.0.1:8000/api/cidade/',
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
            cidades: [],
            busca: {id: '', nome: ''}
         }
      },
      methods: {
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
         }
      },
      mounted() {
         this.carregarLista()
         this.carregarCidades()
      }
   }

</script>
