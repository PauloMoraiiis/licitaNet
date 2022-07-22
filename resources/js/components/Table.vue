<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{t}}</th>
                    <th v-if="visualizar.visivel || atualizar.visivel || remover.visivel"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="p in dados" :key="p.id">
                    <th scope="row">{{p.id}}</th>
                    <td>{{p.cod}}</td>
                    <td>{{p.nome}}</td>
                    <td>{{p.cidade.nome}}</td>
                    <td>R${{p.valor}}</td>
                    <td>{{p.estoque}}</td>
                    <td v-if="visualizar.visivel || remover.visivel || atualizar.visivel">
                        <button v-if="visualizar.visivel" class=" btn btn-outline-dark btn-sm" :data-toggle="visualizar.dataToggle" :data-target="visualizar.dataTarget" @click="setStore(p)">Visualizar</button>
                        <button v-if="atualizar.visivel" class="btn btn-outline-primary btn-sm" :data-toggle="atualizar.dataToggle" :data-target="atualizar.dataTarget" @click="setStore(p)">Atualizar</button>
                        <button v-if="remover.visivel" class="btn btn-outline-danger btn-sm" :data-toggle="remover.dataToggle" :data-target="remover.dataTarget" @click="setStore(p)">Remover</button>
                    </td>
                </tr>        
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos', 'atualizar', 'visualizar', 'remover'],
        methods: {
            setStore(p) {
                this.$store.state.transacao.status = ''
                this.$store.state.transacao.mensagem = ''
                this.$store.state.transacao.dados = ''
                this.$store.state.item = p
            }
        }
    }

</script>
