export default class Proprietario {
    constructor(nome = '', tipo = '', documento = '', fone_principal = '', endereco = '', complemento = '', bairro = '',
                cep = '', estado_id = '', cidade_id = '', cidade = Object) {
        this.nome = nome;
        this.tipo = tipo;
        this.documento = documento;
        this.fone_principal = fone_principal;
        this.endereco = endereco;
        this.complemento = complemento;
        this.bairro = bairro;
        this.cep = cep;
        this.estado_id = estado_id;
        this.cidade_id = cidade_id;
        this.cidade = cidade;
    }
}