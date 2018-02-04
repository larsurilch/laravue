export default class CidadeService {
    constructor(resource) {
        this._resource = resource('api/cidades/listing{/id}');
    }

    busca(id) {
        return this._resource
            .get({ id })
            .then(res => res.json(), err => {
                console.log(err)
                throw new Error('Nao foi possível obter as Cidades. Tente mais tarde')
            })
    }
}