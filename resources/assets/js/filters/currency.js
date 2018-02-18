module.exports = (function (value) {
    return `R$ ${parseFloat(value).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`
})