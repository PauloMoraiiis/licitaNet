<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{t}}</th>
                    <th v-if="visualizar.visivel || atualizar || remover"></th>
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
                    <td v-if="visualizar.visivel">
                        <button v-if="visualizar.visivel" class=" btn btn-outline-dark btn-sm" :data-toggle="visualizar.dataToggle" :data-target="visualizar.dataTarget">Visualizar</button>
                        <button v-if="atualizar" class="btn btn-outline-primary btn-sm">Atualizar</button>
                        <button v-if="remover" class="btn btn-outline-danger btn-sm">Remover</button>
                    </td>
                </tr>        
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos', 'atualizar', 'visualizar', 'remover']
    }

</script>
