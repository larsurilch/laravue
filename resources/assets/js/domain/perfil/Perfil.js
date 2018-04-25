export default class Perfil {
    constructor(descricao = '', acao_list = [], acoes = Object) {
        this.descricao = descricao;
        this.acao_list = acao_list;
        this.acoes = acoes;
    }
}