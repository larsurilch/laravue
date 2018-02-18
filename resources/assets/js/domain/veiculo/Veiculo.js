export default class Veiculo {
    constructor(modelo = '', proprietario_id = '', placa = '', ano = '', quilometragem = '', combustivel = '', marca_id = '',
                data_cotacao = new Date().toLocaleDateString("pt-BR"), preco = 0.00, pais_id = '', descricao = '', pais = Object,
                proprietario = Object, marca = Object) {
        this.modelo = modelo;
        this.proprietario_id = proprietario_id;
        this.placa = placa;
        this.ano = ano;
        this.quilometragem = quilometragem;
        this.combustivel = combustivel;
        this.marca_id = marca_id;
        this.data_cotacao = data_cotacao;
        this.preco = preco;
        this.pais_id = pais_id;
        this.descricao = descricao;
        this.pais = pais;
        this.proprietario = proprietario;
        this.marca = marca;
    }
}