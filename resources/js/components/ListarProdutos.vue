<template>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Código</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Estoque</th>
                    <th scope="col">Cidade</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">1</th>
                    <td>{{teste}}</td>
                    <td>5165</td>
                    <td>R$35,00</td>
                    <td>500 Unidades</td>
                    <td>Uberlândia</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        props: ['csrf_token'],
        methods: {

        },
        body: {

        }
    }
</script>
    