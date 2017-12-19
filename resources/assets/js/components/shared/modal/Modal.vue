<template>
    <div class="ui small modal">
        <div class="ui icon header">Exclusão de registro</div>
        <div class="content">
            <p>Você tem certeza que deseja excluir o registro?</p>
            <span class="record-delete"></span>
        </div>
        <div class="actions">
            <div class="ui negative button">Não</div>
            <div class="ui positive right labeled icon button">
                <i class="checkmark icon"></i>
                Sim
            </div>
        </div>
    </div>
</template>

<style scoped>
    .record-delete {
        font-weight: bold;
        color: #db2828;
    }
</style>