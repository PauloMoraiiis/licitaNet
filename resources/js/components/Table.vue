<template>
    <div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{t}}</th>
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
                </tr>        
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos', 'cidades']
    }

</script>
