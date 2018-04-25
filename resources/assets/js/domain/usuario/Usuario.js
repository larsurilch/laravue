export default class Usuario {
    constructor(email = '', senha = '', perfil_id = '', ativo = 1) {
        this.email = email;
        this.senha = senha;
        this.perfil_id = perfil_id;
        this.ativo = ativo;
    }
}